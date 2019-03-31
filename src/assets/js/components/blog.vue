<template>


  <div>
  
  <carousel :pagination-enabled='false' loop :per-page='per_page' class="custom-carousel">
  
  <slide v-for='post in posts_list' :key="post.post_id" class="custom-slide">
	<div :style="slide_body_style" class='slide-body'>
  		<img class='slide-img' :src="post.image">
  		<div class='slide-content'>
  			<div class="container">
  			<div class="row">
  			<div class="col-md-12">
  			<h2 class="post-title" @click="$emit('select_post',post.post_id)">{{ post.post_name }}</h2>
  			<p v-html="post.post_text_brief"></p>
  			</div>
  			</div>
  			</div>
  		</div>
	</div>
  	 
  </slide>
  
</carousel>
  

  </div>
</template>

<script>
/* Promise based HTTP client */
import axios from 'axios';
import { Carousel, Slide } from 'vue-carousel';
import { Card } from 'bootstrap-vue/es/components/card'
// import { Carousel } from 'bootstrap-vue/es/components/carousel'
import bcardg from './bcardg.vue'

// Vue.use(Card)

// my-component.js
export default {
    name: 'blog',
    props: {
    		test: {
    			type: Array,
    			default: function () {
    			    return ['ctrlKey', 'metaKey']
    			  }
    		},
    		demo: {
    			type: String,
    			default: 'Wtf?!'
    		},
    		posts_list: {
    		      type: Array,
//     		      default: [
//     		    	  {
//     		    		  post_id: 1,
//        	         		  post_name: 'demo',
//        	         		  post_text_brief: 'blah blah',
//        	         		  image: 'https://picsum.photos/1024/480/?image=52'
//     		    	  },
//     		    	  {
//        	         		  post_id: 2,
//        	         		  post_name: 'test',
//        	         		  post_text_brief: 'blah blah',
//        	         		  image: 'https://picsum.photos/1024/480/?image=52'
//     		    	  }
//     		      ]
	  		},
    	},
    
    data () {
      return {
    	  selected_post: '',
    	  per_page: 1,
    	  post_in_slide: 0,
          sliding: null,
          demo_list:[
        	  {
        		  id: 1,
        		  text: 'blah blah'
        	  },
        	  {
        		  id: 2,
        		  text: 'blah blah blah blah'
        	  }
        		  
          ],
      }
    },

	computed: {
	    slide_body_style: function () {
	    	return {
	    		  width: $(window).width(),
	    	}
	    },
	},
    
    components: {
        Carousel,
        Slide,
    	Card,
// 		VueCarousel,
//     	Carousel,
    	bcardg
    },
	beforeCreate : function() {
		self = this;
// 		axios.get('/api/blog/get_posts')
// 		  .then(function (response) {
// 			  self.posts_list = response.data;
// 			  self.$refs.blog[0].$refs.carousel.updateSlides();
// 			  self.$refs.carousel.updateSlides();
// 		  })
// 		  .catch(function (error) {
// 			  console.log(error);
// 		  });
//		$.ajax({
//			method : "GET",
//			url : '/api/blog/get_posts',
//			success : function(msg) {
//				self.posts_list = msg;
//			}
//		});
	},
    methods: {
        onSlideStart(slide) {
          this.sliding = true
        },
        onSlideEnd(slide) {
          this.sliding = false
        }
	},
}

</script>

<style scoped>
.custom-carousel .card-img-overlay{
/* 	padding-top: 7rem */
	padding: 7rem 3.25rem;
}
.custom-carousel {
/*  height: 800px;  */
}
.custom-slide {
/* 	background: green; */
/* 	background-image: url('/assets/images/astronomen_1920.jpg'); */
/*  	position: absolute; */
/*    	height: 700px;  */
	
	
}
.custom-slide > img {
  	width: 100%; 
}
.custom-b-card {
	border-radius: 0rem;
	border: none;
}

.slide-img {
/* 	margin-left: -10px; */
	object-fit: cover;
 	width: auto;
 	height: 100%;
 	opacity: 0.7;
}

.slide-body {
	position: relative;
	overflow: hidden;
	display: block;
/* 	width: 61.25rem; */
    height: 100rem;
}

.slide-content {
	color: white;
	text-shadow: 0 0 3px black;
	font-size: 34px;
	position: absolute;
	top: 20%;
	left: 0;
	width: 100%;
	height: auto;
	padding: 17rem 3.25rem;
}

.post-title{
	text-align: left;
	font-size: 55px;
/* 	color: white; */
/* 	text-shadow: 2px 2px black; */
}

.post-title:hover{
	cursor: pointer;
	text-shadow: 0 0 6px white;
	color: black;
}
/*
.custom-carousel .VueCarousel-pagination{
	position: absolute;
	bottom: 100px;
}
*/

</style>
