<script setup>
import { ref,onMounted} from "vue";

let categories = ref([]);
let title = ref("");
let description = ref("");
let link = ref("");
let category_id = ref(null);
onMounted(()=>{
    axios.get("/api/categories").then((response)=>{
            categories.value = response.data;
        });
});


function createResource() {
    /*
    console.log("Creating Resource...");
    console.log(title.value);
    console.log(description.value);
    console.log(link.value);
    */
    
    axios 
        .post("/api/resources",{
            title:title.value,
            description: description.value,
            link:link.value,
            category_id: category_id.value,
        }
        ).then((response)=>{
            window.location.href = "/";
        })
        .catch((error)=>{
            alert(error.message);
        });
}
</script>

<template>
    <div class="m-8">
        <input type="text" v-model="title"/>
        <input type="text" v-model="description"/>
        <input type="text" v-model="link"/>
        <select v-model="category_id">
            <option v-for="category in categories" :key="category_id" :value="category.id">
                {{ category.name }}
            </option>
        </select>
        <button @click="createResource">Crear recurso</button>
    </div>
</template>