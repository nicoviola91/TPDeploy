@extends('layouts.adminApp')
@extends('scripts.googleMaps')


@section('title')
	Ficha Legal
@endsection

@section('head')

	<!-- DATATABLES -->
	<link rel="stylesheet" href="{{ asset('/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
	<script src="{{ asset('/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

	<style type="text/css">
		
		.pac-container {

			z-index: 99999;
		}

	</style>

@endsection

@section('pageHeader')
<h1>
	Ficha Legal
</h1>

@endsection

@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-10 col-md-offset-1">
    <div class="box-body">
      <div class="box-group">
        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
        <div class="panel box box-danger">
          <div class="box-header with-border">
            <h4 class="box-title">
              <a data-toggle="collapse" href="#collapseOne">
                Antecedentes 
              </a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in">
            <div class="box-body ">
                
              @if(($asistido->checkFichaLegal)==1)
              
                @foreach($antecedentes as $antecedente)
                  <div class="box-tools pull-right">
                    <a href="{{ route('fichaLegal.destroyAntecedente',['id'=>$antecedente->id,'asistido_id'=>$asistido->id])}}" class="descartarBtn" data-id="{{$antecedente->id}}" data-toggle="tooltip" data-title="Descartar Antecedente">
                        <i class="fa fa-trash"></i>
                    </a>
                  </div>
                  <dl class="dl-horizontal" >
                    @if(isset($antecedente->resumen))
                    <dt>Resumen</dt>
                    <dd>{{$antecedente->resumen}}</dd>
                    @endif
                    @if(isset($antecedente->radicacion))
                    <dt>Radicación</dt>
                    <dd>{{$antecedente->radicacion}}</dd>
                    @endif
                    @if(isset($antecedente->profesional))
                    <dt>Profesional a cargo</dt>
                    <dd>{{$antecedente->profesional}}</dd>
                    @endif
                    @if(isset($antecedente->estadoTramite))
                    <dt>Estado del trámite</dt>
                    <dd>{{$antecedente->estadoTramite}}</dd>
                    @endif
                    @if(isset($antecedente->recomendacionPosadero))
                    <dt>Recomendación Posadero</dt>
                    <dd>{{$antecedente->recomendacionPosadero}}</dd>
                    @endif
                 

                  </dl>
                @endforeach
                @endif 


              <a href="#" data-toggle="modal" data-target="#modal-agregar"><i align="left" class="fa fa-plus"></i>  Agregar Antecedente</a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modal-agregar">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Agregar Antecedente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
              <form id="nuevoContacto-form" method="POST" action="{{ route('fichaLegal.storeAntecedente',['asistido_id'=>$asistido->id]) }}">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="box-body">
                        <div class="form-group">          
                        {!! Form::Label('ramaDerecho_id', 'Rama del derecho involucrada') !!}
                        <select class="form-control" name="ramaDerecho_id" id="ramaDerecho_id" required >
                            @foreach($ramasDerecho as $ramaDerecho)
                            <option value="{{$ramaDerecho->id}}">{{$ramaDerecho->descripcion}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('resumen') ? ' has-error' : '' }}">
                        <label for="resumen">Resumen del caso</label>
                        <input type="text" class="form-control" id="resumen" placeholder="Ingrese un resumen del caso" name="resumen" maxlength="1000" required>
                        @if ($errors->has('resumen'))
                            <span class="help-block">
                                <strong>{{ $errors->first('resumen') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('radicacion') ? ' has-error' : '' }}">
                            <label for="radicacion">Datos de radicación del juicio</label>
                            <input type="text" class="form-control" id="resumen" placeholder="Datos de la radicación del juicio" maxlength="250" name="radicacion" >
                        @if ($errors->has('radicacion'))
                            <span class="help-block">
                                <strong>{{ $errors->first('radicacion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('profesional') ? ' has-error' : '' }}">
                            <label for="profesional">Abogado representante del asistido</label>
                            <input type="text" class="form-control" id="profesional" placeholder="Si el asistido tuvo un representante, ingrese sus datos" maxlength="250" name="profesional" >
                        @if ($errors->has('profesional'))
                            <span class="help-block">
                                <strong>{{ $errors->first('profesional') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('estadoTramite') ? ' has-error' : '' }}">
                            <label for="estadoTramite">Estado del trámite</label>
                            <input type="text" class="form-control" id="estadoTramite" placeholder="Ingrese el estado actual del trámite" maxlength="250" name="estadoTramite" >
                        @if ($errors->has('estadoTramite'))
                            <span class="help-block">
                                <strong>{{ $errors->first('estadoTramite') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('recomendacionPosadero') ? ' has-error' : '' }}">
                        <label for="recomendacionPosadero">Recomendación Posadero</label>
                        <input type="text" class="form-control" id="recomendacionPosadero" placeholder="Ingrese la recomendación del posadero" maxlength="1000" name="recomendacionPosadero">
                        @if ($errors->has('recomendacionPosadero'))
                            <span class="help-block">
                                <strong>{{ $errors->first('recomendacionPosadero') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Agregar </button>
                </div>
                </form>
            </div>
            </div>
        </div>
        
        </div>




        
    </div>
    </div>
</div>
@endsection

@section('scripts') 

@endsection