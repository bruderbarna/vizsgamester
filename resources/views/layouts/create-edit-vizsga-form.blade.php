<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('targy_nev', 'Tárgy neve:') !!}
            {!! Form::text('targy_nev', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('vizsga_idotartam', 'Vizsga időtartam percekben (ennyi ideig írhatja a vizsgát a vizsgázó):') !!}
            {!! Form::number('vizsga_idotartam', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('tol', 'Írható (tól)') !!}
            {!! Form::text('tol', null, ['class' => array('form-control', 'datetimepicker-input'), 'id' => 'tol', 'data-toggle' => 'datetimepicker', 'data-target' => '#tol', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('ig', 'Írható (ig)') !!}
            {!! Form::text('ig', null, ['class' => array('form-control', 'datetimepicker-input'), 'id' => 'ig', 'data-toggle' => 'datetimepicker', 'data-target' => '#ig', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <button type="submit" class="btn btn-primary">Küldés</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        function initDatetimepicker(id, value) {
            var params = {
                format: 'YYYY-MM-DD HH:mm',
            };

            if (value)
                params.date = value;

            $(id).datetimepicker(params);
        }

        initDatetimepicker('#tol'{!! isset($tol) ? (", '" . $tol . "'") : ''!!});
        initDatetimepicker('#ig'{!! isset($ig) ? (", '" . $ig . "'") : ''!!});
    });
</script>
