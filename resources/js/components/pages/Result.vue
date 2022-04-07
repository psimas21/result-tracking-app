<template>
    <v-app>
        <v-row>
            <v-col>
                <template>
                    <v-card>
                        <v-card-title>
                        <v-btn class="primary text-capitalize" @click="addModal=true">
                            <v-icon>mdi-plus</v-icon>
                            New Result
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="mdi-account-search" label="Search" single-line hide-details></v-text-field>
                        </v-card-title>
                        <v-data-table :headers="headers" :items="results" :search="search" >
                        <template v-slot:item="row">
                            <tr>
                                <td>{{ row.index + 1}}</td>
                                <td>{{ row.item.total_votes_casted }}</td>
                                <td class="text-xs-right">{{ row.item.party_name }}</td>
                                <td class="text-xs-right">{{ row.item.lga }}</td>
                                <td class="text-xs-right">{{ row.item.ward }}</td>
                                <td class="text-xs-right">{{ row.item.polling_unit }}</td>
                                <td class="text-xs-right">
                                    <v-btn  class="error text-capitalize" x-small @click="showEditModal(row.item, row.index)">Update</v-btn>
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
                <!-- New Result Modal -->
                <Modal v-model="addModal" title="Upload New Result" :closable="false" :mask-closable="false">
                    <Form>
                        <FormItem>
                            <Input v-model="data.total_votes_casted" placeholder="Enter Result" required></Input>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.party_id" placeholder="select party">
                                    <Option v-for="(party, i) in parties" :key="i" v-bind:value="party.id" >{{ party.party_name }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.lga_id" placeholder="select lga">
                                    <Option v-for="(lg, i) in lgas" :key="i" v-bind:value="lg.id" >{{ lg.lga }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.ward_id" placeholder="select ward">
                                    <Option v-for="(ward, i) in wards" :key="i" v-bind:value="ward.id" >{{ ward.ward }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                        <FormItem>
                            <template>
                                <Select class="form-control" v-model="data.polling_unit_id" required placeholder="select polling unit">
                                    <Option value="">...</Option>
                                    <Option v-for="(pu, i) in pollingUnits" :key="i" :value="pu.id" >{{ pu.polling_unit }}</Option>
                                </Select>
                            </template>
                        </FormItem>
                    </Form>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="postResult">Post Result</Button>
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
                results: [],
                data:{
                    total_votes_casted: 0,
                    polling_unit_id: 0,
                    ward_id: 0,
                    party_id: 0,
                    lga_id: 0,
                    state_id: 2,
                    user_id: 4,
                },
                editData:{
                    name: '',
                    phone_no: '',
                    status: 0,
                    role: '',
                    role_id: 0,
                },
                users: [],
                // Result Page Variables
                lgas: [],
                wards: [],
                pollingUnits: [],
                // End Result Page Variables
                addModal: false,
                editModal: false,
                index: -1,
                search: '',
                headers: [
                { text: '#', align: 'start', sortable: false, value: 'serial'},
                { text: 'Vote', align: 'start', sortable: false, value: 'votes'},
                { text: 'Party', value: 'phone', sortable: false, align: 'start'},
                { text: 'LGA', value: 'role', sortable: false, align: 'start'},
                { text: 'Ward', value: 'status', sortable: false, align: 'start'},
                { text: 'Polling Unit', value: 'status', sortable: false, align: 'start'},
                { text: 'Action', value: 'action', sortable: false, align: 'start'},
                ],
            }
        },
        watch: {
            'data.lga_id': function(){
                this.fetchWard()
            },
            'data.ward_id'(){
                this.fetchPU()
            },
        },
        methods: {
            async postResult(){
                if (this.data.total_votes_casted == 0) return this.e('result is required!')
                if (this.data.party_id == 0) return this.e('party is required!')
                if (this.data.lga_id == 0) return this.e('LGA is required!')
                if (this.data.ward_id == 0) return this.e('ward is required!')
                if (this.data.polling_unit_id == 0) return this.e('PU is required!')
                const res = await this.callApi('post', 'app/create_result', this.data)
                console.log(this.data.total_votes_casted)
                console.log(this.data.party_id)
                console.log(this.data.lga_id)
                console.log(this.data.ward_id)
                console.log(this.data.polling_unit_id)
                console.log(this.data.state_id)
                console.log(this.data.user_id)
                if(res.status == 201){
                    this.fetchResult()
                    // console.log(res.data)
                    this.s('Result posted successful!')
                    this.addModal = false
                    this.data.total_votes_casted = 0
                    this.data.party_id = 0
                    this.data.lga_id = 0
                    this.data.ward_id = 0
                    this.data.polling_unit_id = 0
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
            },
            // Result Page Methods
            async fetchResult(){
                const res = await this.callApi('get', 'app/get_result')

                if (res.status==200) {
                    this.results = res.data
                    console.log(this.results)
                }
                else{
                    this.swr()
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
            async fetchWard(){
                const res = await this.callApi('get', 'app/get_ward/' + this.data.lga_id);
                if (res.status==200) {
                    this.wards = res.data
                }
                else{
                    this.swr()
                }
            },
            async fetchPU(){
                const res = await this.callApi('get', 'app/get_pus/' + this.data.ward_id + '/' +this.data.lga_id);
                if (res.status==200) {
                    this.pollingUnits = res.data
                }
                else{
                    this.swr()
                }
            },
            // End Result Page Methods
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
            this.fetchResult()
            this.fetchLga()
        }
    }
</script>