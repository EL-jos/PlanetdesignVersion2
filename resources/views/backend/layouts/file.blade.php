<div class="form-group">

    <div class="custom-file">
        <input type="file" class="custom-file-input" id="document" @if($isMultiple) name="document[]" multiple @else name="document" @endif />
        <label class="custom-file-label" for="document">Choisir un fichier</label>
    </div>
</div>
