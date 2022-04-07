<template>
    <v-app>
        <v-container>
            <v-row>
               <h1>Welcome!</h1>
               <Select v-model="selectedVal" @change="onChange">
                   <Option value="1">One</Option>
                   <Option value="2">Two</Option>
               </Select>
            </v-row>
        </v-container>
    </v-app>
</template>

<script setup>
    export default {
        data() {
            return{
                selectedVal: '',
            }
        },
        methods: {
            onChange(){
                console.log(this.selectedVal)
            }
        },
    }
</script>