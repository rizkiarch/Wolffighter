@extends('layouts.main')
@section('content')
    <q-page-container>
        <q-page class="row flex flex-center">
            <div class="col-md-4 col-xs-12">
                <q-card>
                    <q-card-section>
                        <div class="text-h6">Login</div>
                    </q-card-section>

                    <q-separator></q-separator>
                    
                    <q-form 
                    @submit="doLogin"
                    autocorrect="off"
                    autocapitalize="off"
                    autocomplete="off"
                    spellcheck="false"
                    >

                        <q-card-section>
                            <div class="q-gutter-sm">
                                <q-input v-model="form.branch_code" type="number" label="Branch Code"
                                lazy-rules :rules="[ val => val && val.length > 0 || 'Branch code is required']"
                                ></q-input>
                                <q-input v-model="form.email" label="Email" type="email"
                                lazy-rules :rules="[ val => val && val.length > 0 || 'Email is required']"
                                ></q-input>
                                <q-input v-model="form.password" type="password" label="Password"
                                lazy-rules :rules="[ val => val && val.length > 0 || 'Password is required']"
                                ></q-input>
                            </div>
                        </q-card-section>

                        <q-card-section>
                            <q-btn color="primary" class="full-width" label="Login" :loading="loading" type="submit"></q-btn>
                        </q-card-section>
                    </q-form>
                </q-card>
            </div>
        </q-page>
    </q-page-container>

    @push('scripts')

    <script>
        vueApp = {
            data(){

                return{
                    loading:false,
                    form :{
                        email:'',
                        password:'',
                        branch_code:'',
                    }
                }
            },
            methods:{
                async doLogin(){
                    this.loading = true;
                    try{
                        const {request} = await ajax.post('/login', this.form);
                        window.location.href = request.responseURL;
                    }
                    catch (err){
                        console.log(err)
                    }
                    finally{
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    @endpush
@endsection