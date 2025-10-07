@extends('layouts.guest')


@section('content')
    <div class="auth-form-container">
        <h1>Жалоба на пасту</h1>
        <p class="report-paste-info">Вы подаете жалобу на пасту:
            <a href="@if(Route::currentRouteName() == 'complaints.showUuid') {{route('paste.share', $identifier)}} @else {{route('paste.show', $identifier)}} @endif
            ">{{ $paste->title}}</a>
        </p>

        <form method="POST" action="@if(Route::currentRouteName() == 'complaints.showUuid') {{route('complaint.storeUuid', $identifier)}} @else {{route('complaint.storeHashId', $identifier)}} @endif">
            @csrf

            <div class="form-group">
                <label for="details">Опишите вашу жалобу</label>
                <textarea required id="details" name="details" class="paste-textarea"
                          placeholder="Опишите вашу жалобу">{{ old('details') }}</textarea>
                @error('details')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="create-button">Отправить жалобу</button>
        </form>
    </div>
@endsection
