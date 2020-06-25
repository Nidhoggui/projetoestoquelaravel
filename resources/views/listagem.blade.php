@extends('template.site')

@section('titulo','Listagem')

<style>
    .chips-chips{
     margin-bottom:10px;
 }
 .listAcima{
    display:none;
 }
 .listAbaixo{
    display:none;
 }
 .listSem{
    display:none;
 }
 .sem-fundo{
    margin-bottom:0 ;
 }
 .btn.waves-effect.waves-light.gradient.right{
    margin-top:8px !important;
    border-radius:30px !important;
 }

 #resultados {
   border: 1px solid green;
 }
</style>
@section('conteudo')
<!-- nao me apagar vlw -->
<input type="hidden" id="produto_id">

<div class="butaoEspaco">
@if(auth()->user()->is_admin)
    <a href="{{ URL::route('admin.home') }}" class="waves-effect waves-teal btn-flat grey-text text-darken-4">
    <i class="large material-icons">reply</i>
    <span class="ButtaoEspacoTexto"><b>Voltar</span>
    </a>
  @else
    <a href="{{ URL::route('estoqueMenu') }}" class="waves-effect waves-teal btn-flat grey-text text-darken-4 ">
    <i class="large material-icons">reply</i>
    <span class="ButtaoEspacoTexto"><b>Voltar</span>
  </a>
  @endif
</div>
<br>
<br>
<div class="container">
<h4><b>Visualizar Estoque</b>
@if(auth()->user()->is_admin)
<a class="btn waves-effect waves-light gradient right" href="{{route('admin.insercoes')}}">Dar Entrada No Estoque
<i class="material-icons right">add_circle_outline</i>
@else
<a class="btn waves-effect waves-light gradient right" href="{{route('estoqueMenu')}}">Dar Entrada No Estoque
<i class="material-icons right">add_circle_outline</i>
@endif
</a>
</h4>
<div class="row sem-fundo">
<div class="input-field col s12 input-outlined">
        <i class="material-icons prefix right">search</i>
        <input onkeydown="buscarEntrada(event)" id="icon_prefix" type="text" placeholder="Pesquisar...">
        <div id="resultados">
          <ul id="lista_resultados">
            <li>Nome    |    Vencimento</li>
            <br/>
          </ul>
        </div>
    </div>
</div>
<div class="chips-chips" id="chips">
<a id="listEstoque" class="waves-effect waves-light btn-flat gradient" onclick="changeFilter(id)" >Em Estoque</a>
<a id="listAcima" class="waves-effect waves-light btn-flat" onclick="changeFilter(id)" ><i class="material-icons left">add_circle</i>Em grande quantidade</a>
<a id="listAbaixo" class="waves-effect waves-light btn-flat" onclick="changeFilter(id)"><i class="material-icons left">remove_circle</i>Em baixa Quantidade</a>
<a id="listSem" class="waves-effect waves-light btn-flat" onclick="changeFilter(id)" "><i class="material-icons left">cancel</i>Sem Estoque</a>
</div>
</div>
</div>
<div class="container z-depth-2 ">
<table class="listEstoque highlight centered responsive-table">
        <thead>
        <nav class="nav-form blue lighten-1"></nav>
        </thead>
          @if( empty($produtos_estoque))
          <div class="listEstoque">
          <br>
          <br>
            <img src="{{asset('caixa.png')}}" class="list-image" >
            <p class="center-align">Ops! Você ainda não deu entrada de nenhum produto.</p>
            <p class="center-align">Mas não se preocupe! Você pode fazer isso aqui:
            <a href="{{route('admin.insercoes')}}"class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">add</i></a>
            </p>
            <br>
            <br>
          </div>
          @else
          <thead class="grey-text ">
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Quantidade</th>
                <th>Estoque</th>
                <th>Vencimento</th>
            </tr>
          </thead>
          <tbody>
          @foreach($produtos_estoque as $produto)
              <tr>
                  <td>{{$produto->nome}}</td>
                  <td>{{$produto->marca}}</td>
                  <td class="grey-text text-darken-3">
                  @if($produto->quantidade<=$produto->quantidade_minima)
                  <div>{{$produto->quantidade}} {{$produto->abreviacao}}<i class="tiny material-icons red-text">brightness_1</i></div>
                  @else
                  {{$produto->quantidade}} {{$produto->abreviacao}}
                  @endif
                  </td>
                  <td class="grey-text text-darken-3">{{$produto->estoque->estoque}}</td>
                  <td class="grey-text text-darken-3">{{$produto->vencimento}}</td>
              </tr>
          @endforeach
          </tbody>
          @endif
      </table>
      <table class="listAcima highlight centered responsive-table">
      @if(empty($produtos_acima))
      <div class="listAcima">
      <br>
      <br>
      <img src="{{asset('caixa.png')}}" class="list-image" >
      <p class="center-align">Ops! Os produtos estão em baixa quantidade no estoque.</p>
      <br>
      <br>
      </div>
          @else
          <thead class="grey-text ">
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Quantidade</th>
                <th>Estoque</th>
                <th>Vencimento</th>
            </tr>
          </thead>
          <tbody>
          @foreach($produtos_acima as $produto)
              <tr>
                  <td>{{$produto->nome}}</td>
                  <td>{{$produto->marca}}</td>
                  <td class="grey-text text-darken-3">
                  @if($produto->quantidade<=$produto->quantidade_minima)
                  <div>{{$produto->quantidade}} {{$produto->abreviacao}}<i class="tiny material-icons red-text">brightness_1</i></div>
                  @else
                  {{$produto->quantidade}} {{$produto->abreviacao}}
                  @endif
                  </td>
                  <td class="grey-text text-darken-3">{{$produto->estoque->estoque}}</td>
                  <td class="grey-text text-darken-3">{{$produto->vencimento}}</td>
              </tr>
          @endforeach
          </tbody>
          @endif
      </table>
      <table class="listAbaixo highlight centered responsive-table">
      @if( empty($produtos_abaixo))
      <div class="listAbaixo">
      <br>
      <br>
      <img src="{{asset('paper.png')}}" class="list-image" >
      <p class="center-align">Não há nenhum produto abaixo do previsto! Bom trabalho.</p>
      <br>
      <br>
      </div>
          @else
          <thead class="grey-text ">
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Quantidade</th>
                <th>Estoque</th>
                <th>Vencimento</th>
            </tr>
          </thead>
          <tbody>
          @foreach($produtos_abaixo as $produto)
              <tr>
                  <td>{{$produto->nome}}</td>
                  <td>{{$produto->marca}}</td>
                  <td class="grey-text text-darken-3">
                  @if($produto->quantidade<=$produto->quantidade_minima)
                  <div>{{$produto->quantidade}} {{$produto->abreviacao}}<i class="tiny material-icons red-text">brightness_1</i></div>
                  @else
                  {{$produto->quantidade}} {{$produto->abreviacao}}
                  @endif
                  </td>
                  <td class="grey-text text-darken-3">{{$produto->estoque->estoque}}</td>
                  <td class="grey-text text-darken-3">{{$produto->vencimento}}</td>
              </tr>
          @endforeach
          </tbody>
          @endif
      </table>
      <table class="listSem highlight centered responsive-table">
      @if(empty($produtos_sem))
      <div class="listSem">
      <br>
      <br>
      <img src="{{asset('paper.png')}}" class="list-image" >
      <p class="center-align">Não há nenhum produto cadastrado sem estoque! Bom trabalho.</p>
      <br>
      <br>
      </div>
          @else
          <thead class="grey-text ">
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Código de Barra</th>
                <th>tipo</th>
            </tr>
          </thead>
          <tbody>
          @foreach($produtos_sem as $produto)
              <tr>
                  <td>{{$produto->nome}}</td>
                  <td>{{$produto->marca}}</td>
                  <td class="grey-text text-darken-3">{{$produto->codigo_barra}}</td>
                  <td class="grey-text text-darken-3">{{$produto->tipo}}</td>
              </tr>
          @endforeach
          </tbody>
          @endif
      </table>
</div>
@if(!empty($produtos_abaixo))
<div class="container">
<p class="red-text" id="description"><i class="tiny material-icons">brightness_1</i> Indica que o produto está abaixo do esperado</p>
</div>
@endif
<br>
<br>
<br>

<div id="modal1" class="modal confirm">
    <div class="modal-content">
      <h4>Tem certeza que deseja deletar o Produto?</h4>
        <br>
        <div class="row right">
            <input type="hidden" id="modalid"/>
            <button class="btn-flat waves-effect waves-light modal-close" ><b>Cancelar</button>
            <a class="btn waves-effect waves-light red darken-2 modal-close" onclick="deletarProduto()"><b>Deletar</a>
            <br>
    </div>
    </div>
</div>

<div id="modal2" class="modal confirm">
    <div class="modal-content">
      <h4>Tem certeza que deseja deletar a Entrada?</h4>
        <br>
        <div class="row right">
            <input type="hidden" id="modalid"/>
            <button class="btn-flat waves-effect waves-light modal-close" ><b>Cancelar</button>
            <a class="btn waves-effect waves-light red darken-2 modal-close" onclick="deletarEntrada()"><b>Deletar</a>
            <br>
    </div>
    </div>
</div>

<script>
  function changeFilter(id){
        switch(id){
            case "listEstoque":
                changeStateElements(id);
                showMessage(true);
            break;
            case "listAcima":
                changeStateElements(id);
                showMessage(false);
            break;
            case "listAbaixo":
                changeStateElements(id);
                showMessage(true);
            break;
            case "listSem":
                changeStateElements(id);
                showMessage(false);
            break;
        }
    }
    function changeStateElements(id){
        if(!document.getElementById(id).classList.contains("gradient")){
                let list=document.getElementById("chips").getElementsByTagName("A");
                for(item of list){
                    if(item.className.includes("gradient")){
                        item.classList.remove("gradient");
                        document.getElementsByClassName(item.id)[0].style="display:none !important;";
                        if(document.getElementsByClassName(item.id)[1]!=null){
                            document.getElementsByClassName(item.id)[1].style.display="none";
                        }
                        break;
                    }
                }
                document.getElementById(id).classList.add("gradient");
                if(document.getElementsByClassName(id)[0].classList.contains("responsive-table") && window.innerWidth<=400){
                    document.getElementsByClassName(document.getElementById(id).id)[0].style="display:block!important;";
                    if(document.getElementsByClassName(document.getElementById(id).id).lenght>1){
                        document.getElementsByClassName(item.id)[1].style.display="block";
                    }
                }
                else{
                    document.getElementsByClassName(document.getElementById(id).id)[0].style="display:table!important;";
                    if(document.getElementsByClassName(document.getElementById(id).id).lenght>1){
                        document.getElementsByClassName(item.id)[1].style.display="block";
                    }
                }
          }
    }
    function showMessage(state){
      if(document.getElementById("description")!=null){
        if(state){
          document.getElementById("description").style.display="block";
        }
        else{
          document.getElementById("description").style.display="none";
        }
      }
    }
  function confirmarProduto(id) {
    document.getElementById('produto_id').value = id;
    const elem = document.getElementById('modal1');
    const instance = M.Modal.init(elem, {dismissible: false});
    instance.open();
  }

  function confirmarEntrada(id) {
    document.getElementById('produto_id').value = id;
    const elem = document.getElementById('modal2');
    const instance = M.Modal.init(elem, {dismissible: false});
    instance.open();
  }

  function deletarProduto() {
    var id = document.getElementById('produto_id').value;
    window.location.href = "{{route('produto.deletar')}}?id=" + id;
  }

  function deletarEntrada() {
    var id = document.getElementById('produto_id').value;
    window.location.href = "{{route('entrada.deletar')}}?id=" + id;
  }

  function atualizarEntrada(id) {
    document.getElementById('produto_id').value = id;
    window.location.href = "{{route('entradaProduto')}}?id=" + id;
  }

  function atualizarProduto(id) {
    document.getElementById('produto_id').value = id;
    window.location.href = "{{route('produto')}}?id=" + id;
  }

  let query

  function buscarEntrada(event) {
    input = document.getElementById('icon_prefix')
    query = input.value
    let keyCode = event.keyCode

    let lista = document.getElementById("lista_resultados");
    let produtos = []
    
    if((keyCode >= 65 && keyCode <= 90) && (keyCode != 20) || keyCode == 186) {
      lista.innerHTML = ""
      let letra = event.key
      query += letra

      let li = document.createElement('li')
      li.innerHTML = "Nome | Vencimento"
      lista.appendChild(li)

      $.get("{{url('/admin/buscar/entrada?query=')}}" + query, (data, status) => {
        
        for(let i = 0; i < data.length; i++) {
          
          if(document.getElementById(data[i]['id']) == null) {
            let li = document.createElement('li')
            li.innerHTML = data[i]['nome'] + " | " + data[i]['vencimento']
            li.setAttribute('id', data[i]['id']);
            lista.appendChild(li);
          }
          
        }
       });
    } else if(keyCode == 8) {
      newQuery = ""
      for(let i = 0; i < query.length-1; i++) {
        newQuery += query[i]
      }

      $.get("{{url('/admin/buscar/entrada?query=')}}" + newQuery, (data, status) => {
        
        for(let i = 0; i < data.length; i++) {
          
          if(document.getElementById(data[i]['id']) == null) {
            let li = document.createElement('li')
            li.innerHTML = data[i]['nome'] + " | " + data[i]['vencimento']
            li.setAttribute('id', data[i]['id']);
            lista.appendChild(li);
          }
          
        }
       });
    }

  }
</script>
@endsection
