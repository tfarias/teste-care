<div class="form-group col-md-6">
    <label for="ciclo[]" class="control-label required">Ciclo</label>
    <select class="form-control " name="ciclo[]" multiple="" required="required" id="ciclo[]" aria-hidden="true">
        @foreach($ciclos as $c)
            <option value="{{$c->id}}">{{$c->numeros}}</option>
        @endforeach
    </select>
</div>