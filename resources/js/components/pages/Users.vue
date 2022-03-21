<template>
    <v-app>
        <v-row>
            <v-col>
                <template>
                    <v-card>
                        <v-card-title>
                        <v-btn class="primary text-capitalize" @click="addModal=true">
                            <v-icon>mdi-plus</v-icon>
                            New User
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="mdi-account-search" label="Search" single-line hide-details></v-text-field>
                        </v-card-title>
                        <v-data-table :headers="headers" :items="users" :search="search" >
                        <template v-slot:item="row">
                            <tr>
                                <td>{{ row.index + 1}}</td>
                                <td>{{ row.item.name }}</td>
                                <td class="text-xs-right">{{ row.item.phone_no }}</td>
                                <td class="text-xs-right">{{ row.item.role.role }}</td>
                                <td class="text-xs-right">{{ statusText(row.item.status) }}</td>
                                <td class="text-xs-right">
                                    <v-btn  class="error text-capitalize" x-small>Edit</v-btn>
                                </td>
                            </tr>
                        </template>
                        <template v-slot:no-results>
                            <v-alert :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                            </v-alert>
                        </template>
                        </v-data-table>
                    </v-card>
                </template>
                <Modal v-model="addModal" title="Add New User" :closable="false" :mask-closable="false">
                    <Form>
                        <FormItem>
                            <Input v-model="data.name" placeholder="Enter First & Last name" required></Input>
                        </FormItem>
                        <FormItem>
                            <Input v-model="data.email" placeholder="Enter email" required></Input>
                        </FormItem>
                        <FormItem>
                            <Input v-model="data.phone_no" placeholder="Enter phone number" required></Input>
                        </FormItem>
                        <FormItem>
                            <Input v-model="data.password" placeholder="Enter password" required></Input>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.role_id" required placeholder="select role">
                                    <Option v-for="(role, i) in roles" :key="i" v-bind:value="role.id" >{{ role.role }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                    </Form>

                    <div slot="footer">
                        <Button type="warning" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addUser">Add User</Button>
                    </div>
                </Modal>
            </v-col>
        </v-row>
    </v-app>
</template>
<script>
    export default {
        data () {
            return {
                data:{
                    name: '',
                    email: '',
                    phone_no: '',
                    password: '',
                    role_id: 0
                },
                users: [],
                addModal: false,
                search: '',
                headers: [
                { text: '#', align: 'start', sortable: false, value: 'serial'},
                { text: 'Name', align: 'start', sortable: false, value: 'name'},
                { text: 'Phone', value: 'phone', sortable: false, align: 'start'},
                { text: 'Role', value: 'role', sortable: false, align: 'start'},
                { text: 'Status', value: 'status', sortable: false, align: 'start'},
                { text: 'Action', value: 'action', sortable: false, align: 'start'},
                ],
            }
        },
        methods: {
            async addUser(){
                if (this.data.name.trim() == '') return this.e('name is required!')
                if (this.data.email.trim() == '') return this.e('email is required!')
                if (this.data.password.trim() == '') return this.e('password is required!')
                if (this.data.phone_no.trim() == '') return this.e('phone numer is required!')
                if (this.data.role_id == 0) return this.e('role is required!')
                const res = await this.callApi('post', 'app/create_user', this.data)
                if(res.status == 201){
                    this.fetchUser()
                    console.log(res.data)
                    this.s('User has been added successfully!')
                    this.addModal = false
                    this.data.name = ''
                    this.data.email = ''
                    this.data.password = ''
                    this.data.phone_no = ''
                    this.data.role_id = 0
                }
                else{
                    if (res.status==422) {
                        for(let i in res.data.errors){
                            console.log(res.data.errors[i][0])
                            this.e(res.data.errors[i][0])
                        }
                    }
                    else{
                        this.swr()
                    }
                }
            },
            async fetchUser(){
                const res = await this.callApi('get', 'app/get_users')
                if (res.status==200) {
                    this.users = res.data
                }
                else{
                    this.swr()
                }
            }
        },
        created(){
            this.fetchUser()
        }
    }
</script>