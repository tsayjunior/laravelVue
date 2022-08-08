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
    <button type="button" @click="modificar = false; abrirModal();" class="btn btn-primary my-4">
      Nuevo
    </button>

    <!-- The Modal -->
    <div class="modal" :class="{ mostrar: modal }">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{ tituloModal }}</h4>
            <button @click="cerrarModal();" type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="my-4">
              <label for="name">Nombre</label>
              <input v-model="user.name" type="text" class="form-control" id="name" placeholder="Nombre del usuario">
              <span class="text-danger" v-if="errores.name">{{ errores.name[0] }}</span>
            </div>
            <div class="my-4">
              <label for="email">Correo electronico</label>
              <input v-model="user.email" type="email" class="form-control" id="email" placeholder="correo del usuario">
              <span class="text-danger" v-if="errores.email">{{ errores.email[0] }}</span>
            </div>
            <div class="my-4">
              <label for="password">Contraseña</label>
              <input v-model="user.password" type="password" class="form-control" id="password"
                placeholder="Contraseña del usuario">
              <span class="text-danger" v-if="errores.password">{{ errores.password[0] }}</span>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button @click="cerrarModal();" type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">Cancelar</button>
            <button @click="guardar()" type="button" class="btn btn-success" data-bs-dismiss="modal">Guardar</button>
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
        <tr v-for="art in users.data" :key="art.id">
          <th scope="row">{{ art.id }}</th>
          <td>{{ art.name }}</td>
          <td>{{ art.email }}</td>
          <td>
            <button @click="modificar = true; abrirModal(art);" class="btn btn-warning">Editar</button>
          </td>
          <td>
            <button @click="eliminar(art.id)" class="btn btn-danger">Eliminar</button>
          </td>
        </tr>

      </tbody>
    </table>
    <div class="row">
      <div class="col-3 md-3 text-right text-primary">
        {{ users.from }} - {{ users.to }} /total: {{ users.total }}
      </div>
      <div class="col-2 md-2">
        <select class="form-control" v-model="pagination.per_page" @change="listar();">
          <option value="3">3</option>
          <option value="5">5</option>
          <option value="8">8</option>
        </select>
      </div>
      <div class="col-7 md-7 "></div>
      <nav>
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: pagination.page == 1 }"><a href="#" class="page-link"
              @click="pagination.page--; listar();">&lt;</a></li>
          <li class="page-item" :class="{ disabled: pagination.page == 1 }"><a href="#" class="page-link"
              @click="pagination.page = 1; listar();">&laquo;</a></li>
          <li class="page-item" v-for="n in paginas" :key="n" :class="{ active: pagination.page == n }"><a href="#"
              class="page-link" @click="pagination.page = n; listar();">{{ n }}</a></li>
          <li class="page-item" :class="{ disabled: pagination.page == users.last_page }"><a href="#" class="page-link"
              @click="pagination.page++; listar();">&gt;</a></li>
          <li class="page-item" :class="{ disabled: pagination.page == users.last_page }"><a href="#" class="page-link"
              @click="pagination.page = users.last_page; listar();">&raquo;</a></li>

        </ul>

      </nav>
    </div>

  </div>
</template>
<script>
import { arrayTypeAnnotation } from '@babel/types';

export default {
  data() {
    return {
      user: {
        name: 'yy',
        email: 'yuyu',
        password: '',
      },
      id: 0,
      passwordAux: "",
      modificar: true,
      modal: 0,//0=cerrado, 1 = abierto
      tituloModal: "",
      users: [],
      aux: 0,
      errores: {},
      pagination: {
        page: 1,
        per_page: 5,
      },
      paginas: [],
      //  usuario:{
      //    nombre:'',
      //      apellido:''
      // }
    }
  },
  mounted() {

  },
  methods: {
    async listar() {
      const res = await axios.get('api/users', { params: this.pagination });
      this.users = res.data;
      this.listarPaginas();
    },
    async eliminar(id) {
      const res = await axios.delete("api/users/" + id);
      this.listar();
    },
    abrirModal(data = {}) {
      this.modal = 1;
      if (this.modificar) {
        console.log(data)
        this.id = data.id;
        this.tituloModal = "Modificar Usuario";
        this.user.name = data.name;
        this.user.email = data.email;
        this.user.password = "********";
      } else {
        this.tituloModal = "Crear Usuario"
        this.id = 0;
        this.user.name = "";
        this.user.email = "";
        this.user.password = "";
      }
    },
    cerrarModal() {
      this.modal = 0;
      this.errores = {};
    },

    async guardar(id) {
      try {
        if (this.modificar) {
          console.log(this.user.password == "********")
          //if(this.user.password=="********"){

          //}
          const res = await axios.put("api/users/" + this.id, this.user);
        } else {
          const res = await axios.post("api/users", this.user);
        }
        this.cerrarModal();
        this.listar();
      } catch (error) {
        if (error.response.data) {
          this.errores = error.response.data.errors
        }

      }


    },
    auxmetodo() {
      let me = this;
      me.aux
    },
    listarPaginas() {
      const n = 2
      let arrayN = []
      let ini = this.pagination.page - 2
      if (ini < 1) {
        ini = 1
      }
      let fin = this.pagination.page + 2
      if (fin > this.users.last_page) {
        fin = this.users.last_page
      }
      for (let i = ini; i <= fin; i++) {
        arrayN.push(i)
      }
      this.paginas = arrayN
    },

  },
  created() { //llama a la funcion listar
    this.listar();
  }
};
</script>
<style>
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(35, 34, 34, 0.849);

}
</style>