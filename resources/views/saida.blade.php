@extends('template.site')

@section('titulo','Menu')

@section('conteudo')
<style>
.gradient{
    background: linear-gradient(to left, #cb2d3e, #ef473a);;
}
</style>
<div class="butaoEspaco">
    <a href="{{ URL::route('saida.menu') }}" class="waves-effect waves-teal btn-flat grey-text text-darken-4">
    <i class="large material-icons">reply</i>
    <span class="ButtaoEspacoTexto"><b>Voltar</span>
    </a>
</div>
<br>
<br>
<div class="container">
    <h4><b>Saída de Produtos</b></h4>
</div>
<div class="container">
<div class="row sem-fundo">
<div class="input-field col s12 input-outlined">
        <i class="material-icons prefix right">search</i>
        <input id="icon_prefix" type="text" placeholder="Pesquisar...">
        <div id="resultados" class="z-depth-2">
          <table id="tabela_resultados" class="highlight centered responsive-table">
          </table>
        </div>
    </div>
</div>
</div>
<div class="container z-depth-2 ">
<nav class="nav-form blue lighten-1"></nav>
    <table class="highlight centered responsive-table">
        <thead class="grey-text text-darken-4">
            <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Vencimento</th>
                <th>Retirar</th>
            </tr>
          </thead>
          <tbody>
              @foreach($produtos_estoque as $produto)
              <tr>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->quantidade}}</td>
                <td>{{$produto->tipo}}</td>
                <td>{{$produto->marca}}</td>
                <td>{{$produto->vencimento}}</td>
                <td><a onclick="abrirModal('{{$produto->id}}')" class="btn-floating waves-effect waves-light gradient"><i class="material-icons">remove</i></a></td>
              </tr>
              @endforeach
          </tbody>
    </table>
</div>
<div id="modal10" class="modal">
    <div class="modal-content">
    <form action="{{route('saida.post')}}" method="post">
        {{ csrf_field() }}
        @if(isset($entrada))
        <h5><b>Insira as informações de {{$entrada->nome}} para retirá-lo:</b></h5>
        @endif
        <p>Quanto será retirado?</p>
        <div class="row">
            <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                @if(isset($entrada))
                <input required min="1" max="{{$entrada->quantidade}}" placeholder="10" id="qtd" name="quantidade" type="number" >
                @endif
                <label for="qtd">Quantidade</label>
            </div>
            <div class="input-field col s6">
            @if(isset($entrada))
            <p>{{$entrada->medida}}</p>
            @endif
            </div>
            <!-- Tipo de unidade de medida que foi inserida nesse produto-->
        </div>
        <p>Para que será retirado?</p>
        <div class="row">
        <div class="input-field col s6">
                <i class="material-icons prefix">account_circle</i>
                @if(isset($entrada))
                <select name="type_saida" >
                    <option value="doacao">Doação</option>
                    <option value="vencimento">Vencimento</option>
                    <option value="uso">Uso</option>     
                </select>
                @endif
                <label for="qtd">Tipo de Saída</label>
            </div>
        </div>
        @if(isset($entrada))
            <input type="hidden" name="Id_produto" value="{{$entrada->Id_produto}}">
            <input type="hidden" name="Id_doador" value="{{$entrada->Id_doador}}">
            <input type="hidden" name="Id_entrada" value="{{$entrada->id}}">
        @endif
        <button class="btn waves-effect waves-light red darken-2 " type="submit">Retirar</button>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
    </div>
    </form>
</div>

<input type="hidden" id="id_entrada">

<script>
    function abrirModal(id) {
        window.location.href="/saida?id=" + id
    }

    function sleep (time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }
    function exibirModal(modal) {
        sleep(500, 1).then(() => {
            const elem = document.getElementById(modal);
            const instance = M.Modal.init(elem, {dismissible: false});
            instance.open();
        });
    }
</script>

@if(isset($entrada))
    <script>
        exibirModal('modal10')
    </script>
@endif

@endsection
