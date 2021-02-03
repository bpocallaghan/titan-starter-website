<div class="row">
    <div class="col col-md-8">
        <div class="form-group">
            <label for="heading">Heading <span class="small">(Optional)</span></label>
            <input type="text" class="form-control {{ form_error_class('heading', $errors) }}" id="heading" name="heading" placeholder="Enter Heading" value="{{ ($errors && $errors->any()? old('heading') : (isset($item)? $item->heading : '')) }}">
            {!! form_error_message('heading', $errors) !!}
        </div>
    </div>

    <div class="col col-md-4">
        <div class="form-group">
        	<label for="heading_element">Heading Element</label>
        	{!! form_select('heading_element', ([ 'h2' => 'Heading 2', 'h3' => 'Heading 3', 'h4' => 'Heading 4', 'h5' => 'Heading 5']), ($errors && $errors->any()? old('heading_element') : (isset($item)? $item->heading_element : 'h2')), ['class' => 'select2 form-control ' . form_error_class('heading_element', $errors)]) !!}
        	{!! form_error_message('heading_element', $errors) !!}
        </div>
    </div>
</div>
