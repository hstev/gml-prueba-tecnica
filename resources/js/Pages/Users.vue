<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="12" lg="12">
              <h2>Usuarios: {{ state.users.length }} 
                <v-btn variant="text" position="relative" color="success" @click="createUser">
                  <v-icon>mdi-plus</v-icon> Crear nuevo
                </v-btn>
                <v-btn variant="text" position="relative" color="primary" @click="reloadUsers">
                  <v-icon>mdi-database-outline</v-icon> Cargar todos
                </v-btn>
              </h2>
 
              <v-text-field
                class="mx-auto my-5"
                :loading="state.search.loading"
                variant="solo"
                label="Buscador"
                append-inner-icon="mdi-magnify"
                single
                hint="Presione la lupa para realizar la busqueda"
                persistent-hint
                @click:append-inner="searchClick"
                clearable
                v-model="state.search.text"
              ></v-text-field>
   
              <v-table fixed-header>
                  <thead>
                      <tr>
                          <th class="text-left">Categoría</th>
                          <th class="text-left">Nombre</th>
                          <th class="text-left">Apellidos</th>
                          <th class="text-left">Cédula</th>
                          <th class="text-left">Email</th>
                          <th class="text-left">Dirección</th>
                          <th class="text-left">Celular</th>
                          <th class="text-left">Pais</th>
                          <th class="text-left">Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr
                      v-for="item in state.users"
                      :key="item.id"
                      >
                          <td>{{ item.category.name }}</td>
                          <td>{{ item.name }}</td>
                          <td>{{ item.last_name }}</td>
                          <td>{{ item.document }}</td>
                          <td>{{ item.email }}</td>
                          <td>{{ item.address }}</td>
                          <td>{{ item.phone_number }}</td>
                          <td>{{ item.country }}</td>
                          <td>
                              <div class="">
                                  <v-btn-group                                    
                                  divided
                                  density="compact"
                                  >
                                    <v-btn 
                                      color="black"
                                      @click="editUser(item)"
                                      icon="mdi-pencil"
                                    />
                                    <v-btn 
                                      color="red" 
                                      icon="mdi-eraser"
                                      @click="deleteUser(item.id)"
                                    />
                                  </v-btn-group>
                              </div>
                          </td>
                      </tr>
                  </tbody>
              </v-table>
            </v-col>
        </v-row>
    </v-container>

    <v-dialog
      v-model="state.dialog"
      persistent
      width="1024"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">Información del usuario</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="myForm">
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <v-text-field
                    label="Nombres*"
                    :rules="rules.name"
                    :counter="100"
                    v-model="state.formUser.name"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <v-text-field
                    label="Apellidos*"
                    :rules="rules.last_name"
                    :counter="100"
                    v-model="state.formUser.last_name"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <v-text-field
                    label="Cédula*"
                    :rules="rules.document"
                    v-model="state.formUser.document"
                    :counter="10"
                    type="number"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    label="Email*"
                    type="email"
                    :rules="rules.email"
                    :counter="150"
                    v-model="state.formUser.email"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-autocomplete
                    :items="state.categories"
                    label="Categoría*"
                    :rules="rules.category_id"
                    v-model="state.formUser.category_id"
                    item-value="id"
                    item-title="name"
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Dirección*"
                    type="text"
                    :rules="rules.address"
                    v-model="state.formUser.address"
                    :counter="180"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-autocomplete
                    :items="state.countries"
                    label="Pais*"
                    :rules="rules.country"
                    v-model="state.formUser.country"
                  ></v-autocomplete>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    label="Celular*"
                    type="number"
                    :counter="10"
                    :rules="rules.phone_number"
                    v-model="state.formUser.phone_number"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
          <small>*Indica campo requerido</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="state.dialog = false"
          >
            Cerrar
          </v-btn>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="validateForm"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="state.loadingDialog"
      :scrim="true"
      persistent
      width="auto"
    >
      <v-card
        color="grey"
      >
        <v-card-text>
          Espera un momento...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-snackbar
      v-model="state.snackbar.show"
    >
      {{ state.snackbar.text }}

      <template v-slot:actions>
        <v-btn
          color="pink"
          variant="text"
          @click="state.snackbar.show = false"
        >
          Cerrar
        </v-btn>
      </template>
    </v-snackbar>
</template>

<script setup>
    import { ref, reactive, onMounted } from 'vue' 
    const myForm = ref(null);
    const rules = {
      name: [
        value => {
          if (value) return true
          return 'Nombre es requerido'
        },
        value => {
          if(/^[A-Za-z ]+$/.test(value)) return true;
          return 'Nombre inválido'
        },
        value => {
          if (value?.length >= 5) return true
          return 'Nombre muy corto'
        },
        value => {
          if (value?.length <= 100) return true
          return 'Nombre muy largo'
        },
      ],
      last_name: [
        value => {
          if (value) return true
          return 'Apellido es requerido'
        },
        value => {
          if(/^[A-Za-z ]+$/.test(value)) return true;
          return 'Apellido inválido'
        },
        value => {
          if (value?.length <= 100) return true
          return 'Apellido inválido'
        }
      ],
      document: [
        value => {
            if (value) return true
            return 'Documento es requerido'
        },
        value => {
          if (value?.length <= 10 && value?.length >= 8) return true
          return 'Documento no válido'
        },
      ],
      email: [
          value => {
            if (value) return true
            return 'E-mail requerido.'
          },
          value => {
            if (/.+@.+\..+/.test(value)) return true
            return 'E-mail debe ser válido'
          },
      ],
      category_id: [
        value => {
          if (value) return true
          return 'Categoría requerida'
        },
      ],
      address: [
        value => {
          if (value) return true
          return 'Dirección requerida'
        },
      ],
      country: [
        value => {
          if (value) return true
          return 'Pais requerido'
        },
      ],
      phone_number: [
        value => {
          if (value) return true
          return 'Celular requerido'
        },
        value => {
          if (value?.length == 10) return true
          return 'Celular no válido'
        }
      ]
    }
   

    const state = reactive({
        users: [],
        countries: [],
        loadingDialog: false,
        dialog: false,
        formUser: {},
        snackbar: {
          show: false,
          text: ''
        },
        search: {
          text: null,
          loading: false
        }
    });

    const getUsers = async () => {
        state.loadingDialog = true;
        await axios.get('api/user')
        .then(res => {
            state.users = res.data;
        })
        .catch(err => console.error(err))
        state.loadingDialog = false;
    }

    const getCountries = async () => {
        await axios.get('https://restcountries.com/v3.1/region/americas')
        .then(res => {
            state.countries = res.data.map(el => el.translations.spa.common);
        })
        .catch(err => console.error(err))
    }

    const getCategories = async () => {
        await axios.get('api/category')
        .then(res => {
            state.categories = res.data;
        })
        .catch(err => console.error(err))
    }

    const editUser = user => {

        state.formUser.id = user.id;
        state.formUser.category_id = user.category.id;
        state.formUser.name = user.name;
        state.formUser.last_name = user.last_name;
        state.formUser.document = user.document;
        state.formUser.phone_number = user.phone_number;
        state.formUser.address = user.address;
        state.formUser.country = user.country;
        state.formUser.email = user.email;

        state.dialog = true;
    }

    const createUser = () => {
      state.formUser = {};
      state.dialog = true
    }

    const reloadUsers = () => {
      state.search.text = null;
      getUsers();
    }

    const validateForm = async () => {
      const validation = await myForm.value.validate();
      if (validation.valid) {
        saveUser();
      }
    }

    const saveUser = async () => {
      state.loadingDialog = true;
      await axios.post('api/user', state.formUser)
      .then(res => {
        getUsers();
        state.dialog = false;
      })
      .catch(err => {
        state.snackbar.text = err.response.data.message;
        state.snackbar.show = true;
      })
      state.loadingDialog = false;
    }

    const deleteUser = async (user_id) => {
      state.loadingDialog = true;
      await axios.delete(`api/user/${user_id}`)
      .then(res => {
        console.log(res.data)
        getUsers();
      })
      .catch(err => console.error(err))
      state.loadingDialog = false;
    }

    const searchClick = async () => {
      state.search.loading = true;
      await axios.post('api/user/search', { text: state.search.text })
      .then(res => {
        state.users = res.data; 
      })
      .catch(err => console.error(err))
      state.search.loading = false;
    }

    onMounted(() => {
        getUsers();
        getCountries();
        getCategories();
    })
</script>