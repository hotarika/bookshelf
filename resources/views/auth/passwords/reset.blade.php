@extends('layouts.app')

@section('content')
<div class="l-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header c-formAuth__cardHeader">パスワードのリセット</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right c-formAuth__label">メールアドレス</label>

                                <div class="col-md-7 col-lg-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror c-formAuth__input"
                                        name="email" value="{{ $email ?? old('email') }}" autocomplete="email"
                                        autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right c-formAuth__label">パスワード</label>

                                <div class="col-md-7 col-lg-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror c-formAuth__input"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="6~20文字・半角英数字のみ">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right c-formAuth__label">パスワード再入力</label>

                                <div class="col-md-7 col-lg-6">
                                    <input id="password-confirm" type="password" class="form-control c-formAuth__input"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4" style="text-align:right;">
                                    <button type="submit" class="btn btn-primary c-formAuth__btn">リセット</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
