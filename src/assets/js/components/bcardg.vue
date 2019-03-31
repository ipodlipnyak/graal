<template>
<div class="row">

	<b-card-group columns> 
	
  <b-card no-body class="overflow-hidden custom-b-card" style="max-width: 540px;">
    <b-row no-gutters>
      <b-col md="6">
        <b-card-img src="https://picsum.photos/400/400/?image=20" class="rounded-0" />
      </b-col>
      <b-col md="6">
        <b-card-body title="Horizontal Card">
          <b-card-text>
            This is a wider card with supporting text as a natural lead-in to additional content.
            This content is a little bit longer.
          </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
  
  <b-card no-body class="overflow-hidden" style="max-width: 540px;">
    <b-row no-gutters>
      <b-col md="6">
        <b-card-img src="https://picsum.photos/400/400/?image=20" class="rounded-0" />
      </b-col>
      <b-col md="6">
        <b-card-body title="Horizontal Card">
          <b-card-text>
            This is a wider card with supporting text as a natural lead-in to additional content.
            This content is a little bit longer.
          </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
  
  <b-card no-body class="overflow-hidden" style="max-width: 540px;">
    <b-row no-gutters>
      <b-col md="6">
        <b-card-img src="https://picsum.photos/400/400/?image=20" class="rounded-0" />
      </b-col>
      <b-col md="6">
        <b-card-body title="Horizontal Card">
          <b-card-text>
            This is a wider card with supporting text as a natural lead-in to additional content.
            This content is a little bit longer.
          </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
	
	</b-card-group>
	
</div>	
</template>

<script>
import { Card } from 'bootstrap-vue/es/components/card'

// Vue.use(Card)

// my-component.js
export default {
    name: 'bcardg',
    data () {
      return {}
    },
    components: {
    	Card,
    },
    methods: {
	},
}

</script>

<style scoped>
.card-text, .card-title {
	font-size: 0.9rem;
	text-shadow: none;
	color: black;
	text-align: left;
}
.custom-b-card {
	max-width: 540px;
/* 	border-radius: 0rem; */
}
</style>
