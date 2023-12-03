<input type="hidden" name="status_publish" value="-">
<input type="hidden" name="slug" value="-">

@if ($isCreatedPage && auth()->user()->hasRole('super-admin'))
    <div class="form-group col-sm-6">
        {!! Form::label('user_id', 'User:') !!}
        {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'required']) !!}
    </div>
@else
    <input type="hidden" name="user_id" value="-">
@endrole


<!-- Title Field -->
<div class="form-group col-sm-6 mb-2">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 100]) !!}
    @error('title') 
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror 
</div>

@if ($isCreatedPage)
    <!-- Method hanya saat create, tidak bisa diubah -->
    <div class="form-group col-sm-6">
        {!! Form::label('method_id', 'Method: (it cannot be changed later)') !!}
        {!! Form::select('method_id', $methods->pluck('name', 'id'), null, [
            'class' => 'form-control',
            'id' => 'method_id',
            'placeholder' => 'Select a Method',
        ]) !!}
        @error('method_id') 
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror 
    </div>
@endif

<!-- Seo Keyword Field -->
<div class="form-group col-sm-6 mb-2">
    {!! Form::label('seo_keyword', 'Seo Keyword:') !!}
    {!! Form::text('seo_keyword', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
    @error('seo_keyword') 
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror 
</div>

<!-- Seo Description Field -->
<div class="form-group col-sm-6 mb-2">
    {!! Form::label('seo_description', 'Seo Description:') !!}
    {!! Form::text('seo_description', null, ['class' => 'form-control', 'maxlength' => 160]) !!}
    @error('seo_description') 
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror 
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12 mb-2">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control', 'maxlength' => 65535]) !!}
    @error('content') 
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror 
</div>