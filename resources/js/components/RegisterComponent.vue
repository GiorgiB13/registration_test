<template>
    <v-app>
        <div class="container">
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
                class="form"
            >
                <v-text-field
                    v-model="name"
                    :counter="10"
                    :rules="nameRules"
                    label="Name"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                ></v-text-field>
                <v-select
                    v-model="selectedCountry"
                    :items="countries"
                    :rules="[v => !!v || 'Item is required']"
                    label="Country"
                    :prefix="selectedCountry.flag"
                    item-text="name"
                    return-object
                    required
                >
                    <template v-slot:item="slotProps">
                        {{ slotProps.item.flag }}
                        {{ slotProps.item.name }}
                    </template>
                </v-select>
                <v-text-field
                    v-model="number"
                    label="Number"
                    :prefix="selectedCountry.idd"
                    maxlength="10"
                    required
                ></v-text-field>
                <v-btn
                    :disabled="!valid"
                    color="success"
                    class="mr-4"
                    @click="validate"
                >
                    Register
                </v-btn>
            </v-form>
        </div>

    </v-app>
</template>
<script>
import vuetify from "../plugins/vuetify";
import countriesData from '../../data/countries/countries.json';
import axios from "axios";

export default {
    vuetify,
    data: () => ({
        countries: countriesData,
        valid: true,
        name: '',
        nameRules: [
            v => !!v || 'Name is required',
            v => (v && v.length < 11) || 'Name must be less than 10 characters',
        ],
        email: '',
        number: '',
        numberRules: [
            v => !!v || 'E-mail is required',
            v => (v && v.length <= 9) || 'Name must be less than 10 characters',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        selectedCountry: {
            name: null,
            flag: null,
            idd: null
        },
    }),
    watch: {
        number: function () {
            //can be done dynamically just doing Israeli format here :)
            this.number = this.number.replace(/[^0-9]/g, "")
                .replace(/^(\d{2})(\d{3})(\d{2})(\d{2})/g, '$1 $2-$3-$4')
                .substring(0, 12);
        },
        select: function (){
            let countries = this.countries;
            this.selectedCountryObject =  countries.find(country => country.name === this.select)
        }
    },
    methods: {
        validate() {
            this.$refs.form.validate()
            axios.post('/api/users/register', {
                name: this.name,
                country: this.selectedCountry.name,
                phone: this.selectedCountry.idd + ' ' + this.number,
                email: this.email
            }).then((response) => {
                alert(response.data.message);
                this.reset();
            }).catch((error) => {
                if (error.response.status === 422) {
                    alert(error.response.data.message, 'danger');
                    this.reset();
                }
            });
        },
        reset() {
            this.$refs.form.reset()
        },
        resetValidation() {
            this.$refs.form.resetValidation()
        },
    },


}
</script>

<style lang="css">
.container {
    width: 100%;
    height: 100%;
    text-align: center;
}

.form {
    display: inline-block;
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
</style>
