@extends('dashboard.body.main')

@section('specificpagestyles')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Agregar Producto</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
                    @csrf
                        <!-- begin: Input Image -->
                        <div class="form-group row align-items-center">
                            <div class="col-md-12">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ asset('assets/images/product/default.webp') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group mb-4 col-lg-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('product_image') is-invalid @enderror" id="image" name="product_image" accept="image/*" onchange="previewImage();" aria-describedby="product_image">
                                    <label class="custom-file-label" for="product_image">Elegir archivo</label>
                                </div>
                                @error('product_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Image -->
                        
                        <!-- begin: Input Data -->
                        <div class="row align-items-center">
                            <div class="form-group col-md-12">
                                <label for="product_name">Nombre del producto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category_id">Categoría <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                                    <option value="" selected disabled>-- Selecciona la categoría --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="supplier_id">Proveedor <span class="text-danger">*</span></label>
                                <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplier_id" required>
                                    <option value="" selected disabled>-- Selecciona al proveedor --</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product_garage">Cantidad en almacén<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('product_garage') is-invalid @enderror" id="product_garage" name="product_garage" value="{{ old('product_garage') }}" min="0" step="1" required >
                                @error('product_garage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="short_description">Descripción corta<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" value="{{ old('short_description') }}" required>
                                @error('short_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="long_description">Descripción larga<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description" name="long_description" rows="4" required>{{ old('long_description') }}</textarea>
                                @error('long_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="buying_date">Fecha de compra<span class="text-danger">*</span></label>
                                <input id="buying_date" type="text" class="form-control @error('buying_date') is-invalid @enderror" name="buying_date" value="{{ old('buying_date') }}" min="{{ date('Y-m-d') }}" required />
                                @error('buying_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="expire_date">Fecha de expiración<span class="text-danger">*</span></label>
                                <input id="expire_date" type="text" class="form-control @error('expire_date') is-invalid @enderror" name="expire_date" value="{{ old('expire_date') }}" min="{{ date('Y-m-d') }}" required />
                                @error('expire_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="buying_price">Precio de compra <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('buying_price') is-invalid @enderror" id="buying_price" name="buying_price" value="{{ old('buying_price') }}" min="0" step="0.01" required>
                                @error('buying_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="selling_price">Precio de venta <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" min="0" step="0.01" required>
                                @error('selling_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                            <a class="btn bg-danger" href="{{ route('products.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

<script>
    $('#buying_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        minDate: new Date()
    });
    $('#expire_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        minDate: new Date()
    });

    function previewImage() {
        const file = document.getElementById('image').files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            document.getElementById('image-preview').src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-preview').src = "{{ asset('assets/images/product/default.webp') }}";
        }
    }
</script>
@endsection
