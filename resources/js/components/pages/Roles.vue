<template>
    <v-app>
        <v-row>
            <v-col>
                <v-btn class="primary" @click="addModal=true">
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, i) in roles" :key="i" v-if="roles.length">
                                <td>{{i + 1}}</td>
                                <td>{{role.role}}</td>
                                <td>{{role.status}}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <!--END Display the roles-->
                <Modal v-model="addModal" title="Add New Role" :closable="false" :mask-closable="false">
                    <Input v-model="data.newRole" placeholder="Enter Role name.." :border="false" />

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
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
                data: {
                    newRole: ''
                },
                roles: [],
            }
        },
        methods: {
            async addRole(){
            if (this.data.newRole.trim() == '') return this.e('Role is required!')
            const res = await this.callApi('post', 'app/create_role', this.data)
            if(res.status == 201){
                this.roles.unshift(res.data)
                this.s('Role has been added successfully!')
                this.addModal = false
                this.data.newRole = ''
            }
            else{
                if (res.status==422) {
                    if (res.data.errors.tagName) {
                        this.i(res.data.errors.tagName[0])
                    }
                }
                else{
                    this.swr()
                }
            }
        },
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