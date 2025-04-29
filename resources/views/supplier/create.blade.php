@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"> {{$page->title}} </h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form action=" {{ url('supplier')}}" method="POST" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label" style="font-size: 13px">Kode Supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="supplier_id" name="supplier_id" value="{{old('supplier_id')}}" required>
                        @error('supplier_id')
                            <small class="form-text text-danger"> {{$message}} </small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label" style="font-size: 13px">Nama Supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{old('nama')}}" required>
                        @error('nama')
                            <small class="form-text text-danger"></small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{url('supplier')}}" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush