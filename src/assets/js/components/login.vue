<template>

<div class="container">
	<h1>Login</h1>
  <b-form inline>
    <label class="sr-only" for="inlineFormInputName2">Name</label>
    <b-input class="mb-2 mr-sm-2 mb-sm-0" id="inlineFormInputName2" placeholder="Jane Doe" />

    <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
    <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
      <b-input id="inlineFormInputGroupUsername2" placeholder="Username" />
    </b-input-group>

    <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0">Remember me</b-form-checkbox>

    <b-button variant="primary">Save</b-button>
  </b-form>
</div>

</template>

<script>
import { Form } from 'bootstrap-vue/es/components/form'

// Vue.use(Card)

// my-component.js
export default {
    name: 'login',
    data () {
      return {
      }
    },
    components: {
    	Form
    },
    methods: {
	},
}

</script>

<style scoped>
h1{
	color: white;
}
.custom-b-card {
	max-width: 540px;
	border-radius: 0rem;
}
</style>
