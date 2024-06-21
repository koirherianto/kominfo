<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\BackwardChaining\BackwardChaining;
use App\Models\BackwardChaining\BcEvidence;
use App\Models\BackwardChaining\BcGoal;
use App\Models\BackwardChaining\BcRule;
use App\Models\BackwardChaining\BcRuleCode;
use Auth;
use Flash;
use App\Http\Controllers\BackwardChaining\BackwardChaningTryController;
use Illuminate\Support\Facades\Http;

class LandingController extends Controller
{
    function index() {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJkNjM3YjY0ZmM3YzU4MzkxMmFkYTA2NDEyZjBjZDVmY2Y5YTM4ZDYzYmFjMDhlZTE1NDZiZmM5MmViNzBkOTFmZWE3NDY3OGFiOTBiYzExIn0.eyJhdWQiOiIzIiwianRpIjoiMmQ2MzdiNjRmYzdjNTgzOTEyYWRhMDY0MTJmMGNkNWZjZjlhMzhkNjNiYWMwOGVlMTU0NmJmYzkyZWI3MGQ5MWZlYTc0Njc4YWI5MGJjMTEiLCJpYXQiOjE3MTg5NDExMDEsIm5iZiI6MTcxODk0MTEwMSwiZXhwIjoxNzUwNDc3MTAxLCJzdWIiOiI4MTgiLCJzY29wZXMiOlsic2FyYW5hLW9sYWhyYWdhIiwiYmVyaXRhX3BwaWQiXX0.gTUwHsvVxaMd6CuBctNO5q1rMw4_bEdJyIJp5OHqgaGidBC9lzFTqo8f3mueeQzYbea6vCRRt4eDawAmnoStxbouev7qRMe4bkegqvA50BdbTlWGvoSMijxRrb7gLGJZ4i2-IWxzsB0cjvlPRPwTMDe4S8_tX43oDc-LhVZ-jz6s18vf3rqguvY9C4dndQHr2_2CtFArqZTcoL1DMuZ1dhqKFsc9PZle-FlyrqKKNDT_m3HnNYnBMkPM2S9v2MFDKmwgiQsNdINi-vibRq7ZTJBQh8ebs2ZlKOO8k7pDEfUVwYFoySdT84NEmv54YgrRx3kOoGjK2DIiTxp1Fj8R7bJkRRw1RPP_tL3VKPP6dfUEMZFpIT5m4INkVwupcPm1d_IeGQ5UgOlaN9eijZH62uS8b1h23xg-7NQEsodUamQzoF8NwJ-b-OwH5vyERnqBhJF2Fg_XqIrVGuqxYcMN_0BfY8Ew72Zo-F4-3_C1NMcTjxYAeGSy7goccTZi36WfMV9EdHvLFrUcCkA8HroghKd4bYNnailHR5A2YQ_6lmpg47OK2RsQkPjXzoiOlXYDpoiNR0X71Sczj-AXxFsoUz0yX618ee0SKhiffs16E3RDavqLNwzw9-IRGn_yaP24RQkEiLilDB8TDC6msWZvvrVwRmsceKCw8MrH5FF7law'; // Ganti dengan token yang sebenarnya
        $response = Http::withToken($token)->get('http://api.samarindakota.go.id/api/v2/generate/ppid-samarinda/berita_ppid');
        // return $response;
        // if ($response->successful()) {
        //     $data = $response->json();
        //     return response()->json($data);
        // } else {
        //     return response()->json(['error' => 'Request failed'], $response->status());
        // }
         $data = $response->json();

        //  return $data['data'];
        $projects = $data['data'];
        return view('landing.index', compact('projects'));
    }
    
    function blogs(Request $request) {

        return redirect(route('/'));
        if ($request->has('search')) {
            $projects = Project::where('status_publish','yes')->where('title', 'like', '%'.$request->search.'%')->get();
        }else {
            $projects = Project::where('status_publish','yes')->inRandomOrder()->get();
        }

        return view('landing.blogs', compact('projects'))->with('keySearch', $request->search);
    }

    function blog($slug) {

        $project = Project::where('slug', $slug)->first();
        $goals = $project->backwardChaining->bcGoals()->orderBy('created_at', 'desc')->pluck('name', 'id'); 
        $contributors = $project->contributors()->orderBy('created_at', 'desc')->get();   

        return view('landing.blog', compact('project', 'goals','contributors'));
    }

    public function selectEvidences(Request $request)   
    {   
        $currentProject = Project::where('slug', $request->slug)->first();
        // ini ada rule yang harus di penuhi, jika bukan penyakit ini yang keluar
        $selectedRuleModel = BcRule::where('bc_goal_id', $request->bc_goal_id)->get();
        $selectedRules = [];

        foreach ($selectedRuleModel as $selectedRule) {
            $selectedRules[] = [
                'rule_id' => $selectedRule->id,
                'bc_goal_id' => $selectedRule->bc_goal_id,
                'bc_evidence_id' => $selectedRule->bc_evidence_id,
                'bc_rule_code_id' => $selectedRule->bc_rule_code_id,
            ];
        }
        $selectedRules = json_encode($selectedRules);

        // ini adalah goal yang di pilih dari halaman sebelumnya
        $selectedGoal = BcGoal::find($request->bc_goal_id);
        // seluruh evidence yang ada di project, sesuai dengan project yang sedang di kerjakan
        $evidences = $currentProject->backwardChaining->bcEvidences()->orderBy('created_at', 'desc')->get();

        return view('landing.bc.select_evidences', compact('evidences', 'selectedGoal', 'selectedRules'))->with('project', $currentProject);
    }

    public function result(Request $request)
    {
        $currentProject = Project::where('slug', $request->slug)->first();
        $selectedRules = json_decode($request->selected_rules, true);
        $selectedEvidences = $request->selected_evidences;
        // jika tidak ada evidence yang di pilih
        if (empty($selectedEvidences)) {
            Flash::error('Please select at least one evidence');
            return redirect()->route('blog', $currentProject->slug);
        }        

        $selectedEvidencesCount = count($selectedEvidences);
 
        $backwardChaningTryController = new BackwardChaningTryController();
        // Lakukan backward chaining
        $result = $backwardChaningTryController->backwardChaining($selectedRules, $selectedEvidences);

        // Tampilkan atau gunakan hasil sesuai kebutuhan
        return view('landing.bc.result', compact('result','selectedEvidencesCount'))->with('project', $currentProject);
    }
}
