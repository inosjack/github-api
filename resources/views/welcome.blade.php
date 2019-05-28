@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('get.all.issue') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input id="url" placeholder="Type git web url" type="search" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" autocomplete="url" autofocus>

                            @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Get All Issue
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

