<template>
  <div>
    <h1>Gestionar usuarios</h1>
    <hr>


    <!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  nuevo
</button>-->

<!-- Modal -->
<!--<div class="modal fade show" v-if="flag_new" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input class="form-control" v-model="usuario.apellido">
          <input class="form-control" v-model="usuario.nombre">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>-->

  <!-- Button trigger modal 
<button @click="abrirModal();" type="button" class="btn btn-primary">
  nuevo
</button>
-->
<!-- Modal 
<div class="modal fade" :class="{mostrar:modal}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{tituloModal}}</h5>
        <button @click="cerrarModal();" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>-->

  <!-- Button to Open the Modal -->
<button type="button"  @click="modificar=false; abrirModal();" class="btn btn-primary my-4" >
  Nuevo
</button>

<!-- The Modal -->
<div class="modal" :class="{mostrar:modal}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{tituloModal}}</h4>
        <button @click="cerrarModal();" type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="my-4">
          <label for="name">Nombre</label>  
          <input v-model="user.name" type="text" class="form-control" id="name" placeholder="Nombre del usuario">
        </div>
        <div class="my-4">
          <label for="email">Correo electronico</label>  
          <input v-model="user.email" type="email" class="form-control" id="email" placeholder="correo del usuario">
        </div>    
        <div class="my-4">
          <label for="password">Contraseña</label>  
          <input v-model="user.password" type="password" class="form-control" id="password" placeholder="Contraseña del usuario">
        </div>      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button  @click="cerrarModal();" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button  @click="guardar()" type="button" class="btn btn-success" data-bs-dismiss="modal">Guardar</button>
      </div>

    </div>
  </div>
</div>


    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">nombre</th>
          <th scope="col">correo</th>
          <th scope="col" colspan="2" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="art in users" :key="art.id">
          <th scope="row">{{art.id}}</th>
          <td>{{art.name}}</td>
          <td>{{art.email}}</td>
          <td>
              <button @click="modificar=true; abrirModal(art);" class="btn btn-warning">Editar</button>
          </td>
          <td>
              <button @click="eliminar(art.id)" class="btn btn-danger">Eliminar</button>
          </td>
        </tr>
        
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
    data(){
        return {
          user:{
            name:'yy',
            email:'yuyu',
            password:'',
          },
          id:0,
          passwordAux:"",
          modificar:true,
          modal:0,//0=cerrado, 1 = abierto
          tituloModal:"",
            users: [],
            aux: 0,
          //  usuario:{
            //    nombre:'',
          //      apellido:''
           // }
        }
    },
    mounted(){

    },
    methods:{
        async listar(){
               const res=await axios.get('api/users');
               this.users=res.data;
        },
        async eliminar(id){
          const res=await axios.delete("api/users/"+id);
          this.listar();
        },
        abrirModal(data={}){
          this.modal=1;
          if(this.modificar){
            console.log(data)
            this.id=data.id;
            this.tituloModal="Modificar Usuario";
            this.user.name=data.name;
            this.user.email=data.email;
            this.user.password="********";
          }else{
            this.tituloModal="Crear Usuario"
            this.id=0;
            this.user.name="";
            this.user.email="";
            this.user.password="";
          }
        },
        cerrarModal(){
          this.modal=0;
        },

        async guardar(id){
          if(this.modificar){
            console.log(this.user.password=="********")
            //if(this.user.password=="********"){

            //}
            const res=await axios.put("api/users/"+this.id, this.user);
          }else{
            const res=await axios.post("api/users", this.user);
          }
          this.cerrarModal();
          this.listar();
        },
        auxmetodo(){
            let me=this;
            me.aux
        }


    },
    created(){ //llama a la funcion listar
        this.listar();
    }
};
</script>
<style>
.mostrar{
  display:list-item;
  opacity: 1;
  background: rgba(35, 34, 34, 0.849);

}

</style>