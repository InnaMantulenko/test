<template>
    <div class="common-layout">
        <el-progress v-if="showProgress"
                     :percentage="searchProgress"
                     status="success"
        />

        <el-container>

            <el-header>
                <h1>Search Data Form</h1>
            </el-header>

            <el-main>

                <el-form :model="form" :inline="true" class="demo-form-inline">

                    <el-form-item label="Name">
                        <el-input v-model="form.name" @change="get()"/>
                    </el-form-item>

                    <el-form-item label="From Price">
                        <el-input-number v-model="form.from" @change="get()" :min="0"/>
                    </el-form-item>

                    <el-form-item label="To Price">
                        <el-input-number v-model="form.to" @change="get()" :min="0"/>
                    </el-form-item>

                    <el-form-item label="Bedrooms">
                        <el-input-number v-model="form.bedrooms" :min="1" @change="get()" :max="10"
                                         style="width: 120px"/>
                    </el-form-item>

                    <el-form-item label="Bathrooms">
                        <el-input-number v-model="form.bathrooms" @change="get()" :min="1" :max="10"
                                         style="width: 120px"/>
                    </el-form-item>

                    <el-form-item label="Storeys">
                        <el-input-number v-model="form.storeys" @change="get()" :min="1" :max="10"
                                         style="width: 120px"/>
                    </el-form-item>

                    <el-form-item label="Garages">
                        <el-input-number v-model="form.garages" @change="get()" :min="1" :max="10"
                                         style="width: 120px"/>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="get()">Search</el-button>
                    </el-form-item>
                </el-form>

                <el-table :data="data" style="width: 100%">
                    <el-table-column fixed prop="name" label="Name"/>
                    <el-table-column prop="price" label="Price"/>
                    <el-table-column prop="bedrooms" label="Bedrooms"/>
                    <el-table-column prop="bathrooms" label="Bathrooms"/>
                    <el-table-column prop="storeys" label="Storeys"/>
                    <el-table-column prop="garages" label="Garages"/>
                </el-table>

            </el-main>
        </el-container>
    </div>
</template>

<script>
export default {
    mounted() {
        this.get();
    },

    data() {
        return {
            data: [],
            showProgress: false,
            searchProgress: 0,
            form: {
                name: null,
                from: null,
                to: null,
                bedrooms: null,
                bathrooms: null,
                storeys: null,
                garages: null,
            },
        };
    },


    methods: {
        get() {
            this.showProgress = true;

            axios
                .get('/api/search', {params: this.form})
                .then(response => {
                    this.data = response.data.result;
                    if (!this.data.length) alert('There is no data for your search parameters.');
                })
                .finally(response => {
                    this.searchProgress = 100;
                    setTimeout(() => this.showProgress = false, 500)
                });
        },
    },

}
</script>

<style>
header {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
