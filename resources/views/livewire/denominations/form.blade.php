@include('common.modalHead')


<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select id="tipo" wire:model.live="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('type') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <label for="value">Value</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input id="value" type="number" wire:model.live.blur="value" class="form-control" placeholder="ej: 100.00" maxlength="25">
        </div>
        @error('value') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input id="fileInput" type="file" class="custom-file-input form-control" wire:model.live="image"
                accept="image/x-png, image/gif, image/jpeg">
            <label for="fileInput" class="custom-file-label">Imágen {{ $image }}</label>
            @error('image') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>



</div>



@include('common.modalFooter')
