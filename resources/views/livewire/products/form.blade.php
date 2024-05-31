@include('common.modalHead')

<div class="row">
	
<div class="col-sm-12 col-md-8">
	<div class="form-group">
		<label for="inputNombre">Nombre</label>
		<input id="inputNombre"type="text" wire:model.live.blur="name" 
		class="form-control" placeholder="ej: Curso Laravel" autofocus >
		{{-- class="form-control product-name" placeholder="ej: Curso Laravel" autofocus > --}}
		@error('name') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label for="inputCodigo">Código</label>
		<input id="inputCodigo" type="text" wire:model.live.blur="barcode" 
		class="form-control"
		{{-- {{ $selected_id > 0 ? 'disabled' : '' }} 		 --}}
		placeholder="ej: 025974" >
		@error('barcode') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label for="inputCosto">Costo</label>
		<input id="inputCosto"type="text" data-type='currency' wire:model.live.blur="cost" class="form-control" placeholder="ej: 0.00" >
           {{--  //////data-type='currency' porque el type es texto asi que llamamos a ese plugin para que solo ingrese valores nummericos --}}

		@error('cost') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label for="inputPrecio" >Precio</label>
           <input id="inputPrecio" type="text" data-type='currency' wire:model.live.blur="price" class="form-control" placeholder="ej: 0.00" > 
		@error('price') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label for="inputStock">Stock</label>
		<input id="inputStock"type="number"  wire:model.live.blur="stock" class="form-control" placeholder="ej: 0" >
		@error('stock') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label for="inputAlert">Alertas</label>
		<input id="inputAlert"type="number"  wire:model.live.blur="alerts" class="form-control" placeholder="ej: 10" >
		@error('alerts') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>


<div class="col-sm-12 col-md-4">
<div class="form-group">
	<label for="categoriaSelect" >Categoría</label>
	<select id="categoriaSelect" wire:model.live='categoryid' class="form-control">
		<option value="Elegir" disabled>Elegir</option>
		@foreach($categories as $category)
		<option value="{{$category->id}}" >{{$category->name}}</option>
		@endforeach
	</select>
	@error('categoryid') <span class="text-danger er">{{ $message}}</span>@enderror
</div>
</div>



<div class="col-sm-12 col-md-8">
<div class="form-group custom-file">
	<input id="fileInput"  type="file" class="custom-file-input form-control" wire:model.live="image"
	accept="image/x-png, image/gif, image/jpeg"  
	 >
	 <label for="fileInput"class="custom-file-label">Imágen {{$image}}</label>
	 @error('image') <span class="text-danger er">{{ $message}}</span>@enderror
</div>
</div>






</div>




@include('common.modalFooter')