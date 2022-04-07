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
                                <td class="text-xs-right">{{ row.item.role }}</td>
                                <td class="text-xs-right">{{ row.item.lga }}</td>
                                <td class="text-xs-right">{{ statusText(row.item.status) }}</td>
                                <td class="text-xs-right">
                                    <v-btn  class="error text-capitalize" x-small @click="showEditModal(row.item, row.index)">Edit</v-btn>
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
                <!-- New User Modal -->
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
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.lga_id" required placeholder="select lga">
                                    <Option v-for="(lg, i) in lgas" :key="i" v-bind:value="lg.id" >{{ lg.lga }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                    </Form>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addUser">Add User</Button>
                    </div>
                </Modal>
                <!-- End New User Modal -->

                <!-- Edit User Modal -->
                <Modal v-model="editModal" title="Edit User" :closable="false" :mask-closable="false">
                    <Form>
                        <FormItem>
                            <Input v-model="editData.name" placeholder="Enter First & Last name" required></Input>
                        </FormItem>
                        <FormItem>
                            <Input v-model="editData.phone_no" placeholder="Enter phone number" required></Input>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="editData.role_id" v-bind:placeholder="editData.role" required>
                                    <Option v-for="(role, i) in roles" :key="i" v-bind:value="role.id" >{{ role.role }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="editData.status" v-bind:placeholder="statusText(editData.status)" required>
                                    <Option v-bind:value="1" >Enable</Option>
                                    <Option v-bind:value="0" >Disable</Option>
                                </Select>
                            </template>
                        </FormItem>
                    </Form>

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editUser" >Update</Button>
                    </div>
                </Modal>
                <!-- End Edit User Modal -->
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
                    role_id: 0,
                    lga_id: 0
                },
                editData:{
                    name: '',
                    phone_no: '',
                    status: 0,
                    role: '',
                    role_id: 0,
                },
                lgas: [],
                users: [],
                addModal: false,
                editModal: false,
                index: -1,
                search: '',
                headers: [
                { text: '#', align: 'start', sortable: false, value: 'serial'},
                { text: 'Name', align: 'start', sortable: false, value: 'name'},
                { text: 'Phone', value: 'phone', sortable: false, align: 'start'},
                { text: 'Role', value: 'role', sortable: false, align: 'start'},
                { text: 'LGA', value: 'lga', sortable: false, align: 'start'},
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
                if (this.data.lga_id == 0) return this.e('LGA is required!')

                const res = await this.callApi('post', 'app/create_user', this.data)

                if(res.status == 201){
                    this.fetchUser()
                    this.s('User has been added successfully!')
                    this.addModal = false
                    this.data.name = ''
                    this.data.email = ''
                    this.data.password = ''
                    this.data.phone_no = ''
                    this.data.role_id = 0
                    this.data.lga_id = 0
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
            async fetchLga(){
                const res = await this.callApi('get', 'app/get_lga')
                if (res.status==200) {
                    this.lgas = res.data
                }
                else{
                    this.swr()
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
            },
            async editUser(){
                if (this.editData.name.trim() == '') return this.e('name is required!')
                if (this.editData.phone_no.trim() == '') return this.e('phone number is required!')
                const res = await this.callApi('post', 'app/edit_user', this.editData)
                if (res.status===200) {
                    this.fetchUser()
                    this.s('User has been edited successfully!')
                    this.editModal = false
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
            showEditModal(user, index){
                let obj = {
                    id : user.id,
                    name : user.name,
                    phone_no : user.phone_no,
                    role : user.role.role,
                    role_id : user.role_id,
                    status : user.status,
                }
                this.editData = obj
                this.editModal = true
                this.index = index
            },
        },
        created(){
            this.fetchUser()
            this.fetchLga()
        }
    }
</script>