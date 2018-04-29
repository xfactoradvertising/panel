@extends('panelViews::mainTemplate')
@section('page-wrapper')

    @if ($helper_message)
        <div>&nbsp;</div>
        <div class="alert alert-info">
            <h3 class="help-title">{{ trans('rapyd::rapyd.help') }}</h3>
            {{ $helper_message }}
        </div>
    @endif

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <!-- if PENDING (qualify2) criteria exists and this is a response object -->
    @if (!empty(config('blueprint.qualify2-criteria')) && get_class($edit->model) == 'XFactor\Blueprint\Models\Response')

        <!-- if the state is currently in PENDING -->
        @if (strpos($edit->model->current_state, 'PENDING') !== false)

            <!-- show buttons to DNQ or REFERRAL this response -->
            <div class="col-sm-2">
                {!! Button::danger('DNQ')->asLinkTo(route('response-update', [
                        'id' => $edit->model->id,
                        'token' => csrf_token(),
                        'state' => 'DNQ',
                    ]))->addAttributes(['onclick' => 'return confirm("Do you want DNQ this response?");'])
                !!}
            </div>
            <div class="col-sm-10">
                {!! Button::success('REFERRAL')->asLinkTo(route('response-update', [
                        'id' => $edit->model->id,
                        'token' => csrf_token(),
                        'state' => 'REFERRAL',
                    ]))->addAttributes(['onclick' => 'return confirm("Do you want make this response a REFERRAL?");'])
                 !!}
            </div>
        @endif
    @endif

    <p>
        {!! $edit !!}
    </p>

    <input class="btn btn-default" type="button" value="Back" onclick="history.back();">
@stop
