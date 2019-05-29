@extends('layouts.app')
@section('styles')
    <style>
        .result {
            margin-top: 2.75rem;
        }
        th,td {
            text-align: center;
            font-weight: bold;
        }
        .form-control.is-invalid {
            background-image: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <section class="hero">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('fetch.issue-report') }}" id="form-get-open-issue">
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
                            <div class="col-md-12" style="display: flex;justify-content: center;">
                                <button  class="btn btn-primary" type="submit">
                                    <span class="btn-spinner spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                    Check Open Issue
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>


        <section class="result" id="issue-data">

        </section>


    </div>
@endsection

@section('script')

    <script type="application/javascript">
        $('document').ready(function () {
            //..
            $("#form-get-open-issue").submit(function(event){
                event.preventDefault();
                $(this).find('button[type="submit"]').attr("disabled", true).find('.btn-spinner').removeAttr('hidden');
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: (response) => {
                        clearError();
                        hideLoader();
                        $('#issue-data').html(response.view);
                    },
                    beforeSend: () => {
                        clearError();
                        $("#form-get-open-issue").find('button[type="submit"]').attr("disabled", true).find('.btn-spinner').removeAttr('hidden');
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        clearError();
                        hideLoader();
                        if(xhr.status == 409 || xhr.status == 422 || xhr.status == 404){
                            $.each(xhr.responseJSON.errors, ( key, value ) => {
                                $("input[name='"+key+"']").addClass('is-invalid').parent().append('<span class="invalid-feedback" role="alert"><strong>'+value[0]+'</strong></span>');
                            });
                        }
                        else{
                            console.log(xhr.responseText);
                        }

                    }
                })
            });

            const clearError = () => {
                $(".is-invalid").each(function() {
                    $(this).removeClass('is-invalid').parent().find('.invalid-feedback').remove();
                });
            }
            const hideLoader = () => {
                $("#form-get-open-issue").find('button[type="submit"]').attr("disabled", false).find('.btn-spinner').attr('hidden',true);
            }
        });



    </script>
@endsection

