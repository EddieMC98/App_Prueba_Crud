<template>
  <div>
    <h1 class="text-center">LISTA DE ARTICULOS</h1>
    <hr />

    <!-- Button to Open the Modal -->
    <button
      @click="
        modificar = false;
        abrirModal();
      "
      type="button"
      class="btn btn-primary"
    >
      Agregar Nuevo Producto
    </button>
    <br />
    <br />

    <!-- The Modal -->
    <div class="modal" :class="{ mostrar: modal }">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{ tituloModal }}</h4>
            <button
              @click="cerrarModal()"
              type="button"
              class="close"
              data-dismiss="modal"
            >
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="nombre" class="form-label"
                  >Nombre del Producto</label
                >
                <input
                  v-model="producto.name"
                  type="text"
                  class="form-control"
                  id="nombre"
                />
                <span class="text-danger" v-if="errores.name">{{
                  errores.name[0]
                }}</span>
              </div>
                                          <div class="row">
                                            <div class="col">
                <label for="brand" class="form-label">Marca</label>
                <input
                  v-model="producto.brand"
                  type="text"
                  class="form-control"
                  id="brand"
                />
                <span class="text-danger" v-if="errores.brand">{{
                  errores.brand[0]
                }}</span>
</div>
<div class="col">
                 <label for="brand" class="form-label">Año</label>
                <input
                  v-model="producto.año"
                  type="text"
                  class="form-control"
                  id="brand"
                />
                <span class="text-danger" v-if="errores.año">{{
                  errores.año[0]
                }}</span>
              </div>
              </div>
             

              <div class="mb-3">
                <label for="category" class="form-label">Categoria</label>
                <input
                  v-model="producto.category"
                  type="text"
                  class="form-control"
                  id="category"
                />
                <span class="text-danger" v-if="errores.category">{{
                  errores.category[0]
                }}</span>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input
                  v-model="producto.price"
                  type="text"
                  class="form-control"
                  id="price"
                />
                <span class="text-danger" v-if="errores.price">{{
                  errores.price[0]
                }}</span>
              </div>
              <div class="mb-3">
                <label for="details" class="form-label">Detalles</label>
                <textarea
                  v-model="producto.details"
                  type="text"
                  class="form-control"
                  id="details"
                  rows="5"
                />
                <span class="text-danger" v-if="errores.details">{{
                  errores.details[0]
                }}</span>
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              @click="guardar()"
              type="button"
              class="btn btn-success"
              data-dismiss="modal"
            >
              Guardar
            </button>
            <button
              @click="cerrarModal()"
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Marca</th>
          <th scope="col">Año</th>
          <th scope="col">Categoria</th>
          <th scope="col">Precio</th>
          <th scope="col">Descripción</th>
          <th scope="col" colspan="2" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in productos.data" :key="item.id">
          <th scope="row">{{ item.id }}</th>
          <td>{{ item.name }}</td>
          <td>{{ item.brand }}</td>
          <td>{{ item.año }}</td>
          <td>{{ item.category }}</td>
          <td>{{ item.price }}</td>
          <td>{{ item.details }}</td>
          <td>
            <button
              @click="
                modificar = true;
                abrirModal(item);
              "
              class="btn btn-warning"
            >
              Editar
            </button>
          </td>
          <td>
            <button @click="eliminar(item.id)" class="btn btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-3 md-3 text-right text-primary">
        {{ productos.from }} - {{ productos.to }} de: {{ productos.total }}
      </div>
      <div class="col-2 md-2">
        <select class="custom-select" v-model="pagination.per_page" @change="listar();">
          <option value="6">6</option></option>
          <option value="12">12</option>
          <option value="18">18</option>
        </select>
      </div>
      <div class="col-7 md-7">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item" :class="{ disabled: pagination.page == 1 }">
              <a
                class="page-link"
                href="#"
                aria-label="Previous"
                @click="(pagination.page = 1), listar()"
              >
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item" :class="{ disabled: pagination.page == 1 }">
              <a class="page-link" href="#" @click="pagination.page--, listar()"
                >&lt;</a
              >
            </li>
            <li
              class="page-item"
              v-for="n in paginas"
              :key="n"
              :class="{ active: pagination.page == n }"
            >
              <a
                class="page-link"
                href="#"
                @click="(pagination.page = n), listar()"
                >{{ n }}</a
              >
            </li>
            <li
              class="page-item"
              :class="{ disabled: pagination.page == productos.last_page }"
            >
              <a class="page-link" href="#" @click="pagination.page++, listar()"
                >&gt;</a
              >
            </li>
            <li
              class="page-item"
              :class="{ disabled: pagination.page == productos.last_page }"
            >
              <a
                class="page-link"
                href="#"
                aria-label="Next"
                @click="(pagination.page = productos.last_page), listar()"
              >
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      producto: {
        name: "",
        brand: "",
        año:"",
        category: "",
        price: "0.00",
        details: "",
      },
      id: 0,
      productos: [],
      tituloModal: "",
      modal: 0,
      modificar: true,
      errores: {},
      pagination: {
        page: 1,
        per_page: 6,
      },
      paginas: [],
    };
  },

  methods: {
    async listar() {
      const res = await axios.get("productos", { params: this.pagination });
      this.productos = res.data;
      this.listarPaginas();
    },

    listarPaginas() {
      const n = 2;
      let arrayN = [];
      let ini = this.pagination.page - 2;
      if (ini < 1) {
        ini = 1;
      }
      let fin = this.pagination.page + 2;
      if (fin > this.productos.last_page) {
        fin = this.productos.last_page;
      }
      for (let i = ini; i <= fin; i++) {
        arrayN.push(i);
      }
      this.paginas = arrayN;
    },

    async eliminar(id) {
      const res = await axios.delete("/productos/" + id);
      this.listar();
    },

    async guardar(id) {
      try {
        if (this.modificar) {
          const res = await axios.put("/productos/" + this.id, this.producto);
        } else {
          const res = await axios.post("/productos", this.producto);
        }
        this.cerrarModal();
        this.listar();
      } catch (error) {
        if (error.response.data) {
          this.errores = error.response.data.errors;
        }
      }
    },

    abrirModal(data = {}) {
      this.modal = 1;
      if (this.modificar) {
        this.id = data.id;
        this.tituloModal = "Editar Producto";
        this.producto.name = data.name;
        this.producto.brand = data.brand;
        this.producto.año = data.año;
        this.producto.category = data.category;
        this.producto.price = data.price;
        this.producto.details = data.details;
      } else {
        this.id = 0;
        this.tituloModal = "Agregar Producto";
        this.producto.name = "";
        this.producto.brand = "";
        this.producto.año="";
        this.producto.category = "";
        this.producto.price = "0.00";
        this.producto.details = "";
      }
    },

    cerrarModal() {
      this.modal = 0;
      this.errores = {};
    },
  },

  //Ciclo de vida
  created() {
    this.listar();
  },
};
</script>

<style scoped>
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(44, 38, 75, 0.849);
}
</style>