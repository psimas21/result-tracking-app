<template>
    <v-app>
        <v-row>
            <v-col>
                <v-btn class="primary text-capitalize" @click="addModal=true">
                    <v-icon>mdi-plus</v-icon>
                    New User
                </v-btn>
                <Modal v-model="addModal" title="Add New User" :closable="false" :mask-closable="false">
                    <p>Content of dialog</p>
                    <p>Content of dialog</p>
                    <p>Content of dialog</p>

                    <div slot="footer">
                        <Button type="warning" @click="addModal=false">Close</Button>
                        <Button type="primary">Add User</Button>
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
                addModal: false
            }
        },
        methods: {

        }
    }
</script>