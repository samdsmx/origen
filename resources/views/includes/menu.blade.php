@if( sizeof( $menu ) > 0 )
    @foreach($menu as $opc)
        <li>
            <a href="{!! $opc["url"] !!}"><i class="{!! $opc["icono"] !!}"></i><span 
                    style="width: 200px; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-break: break-word;">{!! $opc["texto"] !!}</span></a>
        </li>
    @endforeach
@endif




