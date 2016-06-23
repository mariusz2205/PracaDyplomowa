@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="">

            <form action="{{route('SaveAddressInformation')}}" method="post">
                <div class="form-group col-md-12">
                    <label for="address">Adres</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>

                <div class="form-group col-md-12">
                    <label for="address">Numer telefonu</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number">
                </div>

                <div class="form-group col-md-6">
                    <label for="city">Miejscowoć </label>
                    <input type="text" class="form-control"  id="city" name="city">
                </div>

                <div class="form-group col-md-6">
                    <label for="postal_code">Kod pocztowy </label>
                    <input type="text" class="form-control" id="postal_code" name ='postal_code' >
                </div>

                <div class="checkbox col-md-12">
                    <label><input name="terms" type="checkbox"> Akceptuje regulamin</label>
                    <br>
                    <button type="submit"  class="btn btn-default">Dalej</button>
                    <input type="hidden" name="_token" value="{{Session::token()}}">
                </div>

            </form>

        </div>

    </div>
    @include('includes.errors')
@endsection
