@extends('layouts.lemon')
@section('content')
<q-page-container>
  <q-page class="my-background row justify-center items-center">
    <!--
      window-height window-width -->
    <div class="column">
      <div class="row">
        <h5 class="text-h5 text-white q-my-md">Login Page</h5>
      </div>
      <div class="row">
        <q-card shadow-3 square style="width: 300px; height: 485px">
          <q-card-section>
            <q-item>
              <q-item-section avatar>
                <q-avatar>
                  <img src="{{URL::asset('/images/lemon-icon.svg')}}" />
                </q-avatar>
              </q-item-section>

              <q-item-section class="text-yellow-8">
                <q-item-label>Lemon Store</q-item-label>
              </q-item-section>
            </q-item>
            <q-form class="q-px-sm q-pt-xl">
              <q-input
                square
                clearable
                color="yellow-9"
                v-model="formData.username"
                type="email"
                :error-message="formError.username"
                :error="formError.username ? true : false"
                label="Username"
              >
                <template v-slot:prepend>
                  <q-icon color="yellow-9" name="person" />
                </template>
              </q-input>
              <q-input
                square
                clearable
                color="yellow-9"
                v-model="formData.password"
                :error-message="formError.password"
                :error="formError.password ? true : false"
                type="password"
                label="Password"
              >
                <template v-slot:prepend>
                  <q-icon color="yellow-9" name="lock" />
                </template>
              </q-input>
            </q-form>
          </q-card-section>

          <q-card-actions class="q-px-lg">
            <q-btn
              elevated
              size="lg"
              color="yellow-9"
              class="full-width text-white"
              label="Login"
              @click="login"
            />
          </q-card-actions>
          {{-- <q-card-section>
            <div class="text-center">
              <q-btn color="indigo-7">
                <q-icon class="q-mr-xs" name="facebook" size="1.2rem" />
                Login with facebook
              </q-btn>
            </div>
          </q-card-section> --}}
        </q-card>
      </div>
    </div>
  </q-page>
</q-page-container>

@endsection


@section('scripts')
<script>
  const { useQuasar } = Quasar
  const { createApp, ref } = Vue
  const web = axios.create({
    baseURL: window.location.hostname
  });

  const app = Vue.createApp({
    setup () {
      const formData = ref({
        username: "",
        password: "",
      });
      const formError = ref({});
      const loading = ref(false);
      const login = () => {
        loading.value = true;
        formError.value = {};

        web
          .post("login", formData.value)
          .then(({ data }) => {
            loading.value = false;

            if (data.success) {
              window.location.href = "/app/dashboard";
            } else {
              formError.value.username = data.message;
            }

            Notify.create({
              message: data.message,
              color: data.status ? "primary" : "negative",
            });
          })
          .catch((error) => {
            loading.value = false;
            if (error.response) {
              if (error.response.status == 422) {
                let data = error.response.data;

                errorData.value = data.data;
              }
            }
          });
      };

      return {
        login,
        formData,
        formError,
      };
    }
  })

  app.use(Quasar, { config: {} })
  app.mount('#q-app')
</script>
@endsection