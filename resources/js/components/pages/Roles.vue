<template>
    <v-app>
        <v-row>
            <v-col>
                <v-btn class="primary text-capitalize" elevation="2" @click="addModal=true">
                    <v-icon>mdi-plus</v-icon>
                    New Role
                </v-btn>
                <!--Display the roles-->
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, i) in roles" :key="role.id" v-if="roles.length">
                                <td>{{i + 1}}</td>
                                <td>{{role.role}}</td>
                                <td>active</td>
                                <td>
                                    <v-btn class="warning text-capitalize" x-small @click="disableShow(role, i)">Disable</v-btn>
                                    <!-- Disable/Enable Modal -->
                                    <Modal v-model="disableModal" width="360">
                                        <p slot="header" style="color:#f60;text-align:center">
                                            <Icon type="ios-information-circle"></Icon>
                                            <span>Confirmation</span>
                                        </p>
                                        <div style="text-align:center">
                                            <p>After this Role is disabled will not be available again</p>
                                            <b>Will you disable it?</b>
                                        </div>
                                        <div slot="footer">
                                            <Button type="warning" size="large" long :loading="modal_loading" @click="disableRole">Disable</Button>
                                        </div>
                                    </Modal>
                                    <!-- END Disable/Enable Modal -->
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <!--END Display the roles-->
                <Modal v-model="addModal" title="Add New Role" :closable="false" :mask-closable="false">
                    <Input v-model="data.role" placeholder="Enter Role name.." :border="false" />

                    <div slot="footer">
                        <Button type="warning" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addRole">Add Role</Button>
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
                addModal: false,
                disableModal: false,
                data: {
                    role: ''
                },
                disableData: {
                    role: ''
                },
                roles: [],
                index: -1
            }
        },
        methods: {
            async addRole(){
                if (this.data.role.trim() == '') return this.e('Role is required!')
                const res = await this.callApi('post', 'app/create_role', this.data)
                if(res.status == 201){
                    this.roles.unshift(res.data)
                    this.s('Role has been added successfully!')
                    this.addModal = false
                    this.data.role = ''
                }
                else{
                    if (res.status==422) {
                        if (res.data.errors.role) {
                            this.i(res.data.errors.role[0])
                        }
                    }
                    else{
                        this.swr()
                    }
                }
            },
            async disableRole(){
                const res = await this.callApi('post', 'app/disable_role', this.disableData)
                if(res.status == 200){
                    this.roles.splice(this.index, 1)
                    this.s('Role disabled successfully!')
                    this.disableModal = false
                }
                else{
                    this.swr()
                }
            },
            disableShow(role, index){
                let obj = {
                    id : role.id,
                    role : role.role
                }
                this.disableData = obj
                this.disableModal = true
                this.index = index
            }
        },
        async created(){
            const res = await this.callApi('get', 'app/get_roles')
            if (res.status==200) {
                this.roles = res.data
            }
            else{
                this.swr()
                console.log(res)
            }
        }
    }
</script>
