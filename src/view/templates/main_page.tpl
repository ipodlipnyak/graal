{% extends theme %}

{% block head %}
    {{ parent() }}
    <style type="text/css">
    [v-cloak] { display: none; }
    </style>
{% endblock %}

{% block content %}
  <b-navbar id="nav-header" fixed="top" type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item v-if="selected_post" @click.prevent="togglePostMenu()" right><i class="material-icons">format_list_bulleted</i></b-nav-item>
      <b-nav-item :class="{'white' : !postTextBlack}" v-if="selected_post" @click.prevent="toggleTextColor()" right><i class="material-icons">brightness_auto</i></b-nav-item>
      
      
      <b-nav-item v-if="!selected_post" v-for="(section,index) in sections" :style="{ color: section.bgColor }" @click="gotoSection(index)" :key="section.bgColor" :active="index == $ksvuefp.currentIndex">${ section.name }<span></span></b-nav-item>
    </b-navbar-nav>
    <b-navbar-nav class="ml-auto">
      	<b-nav-item v-if="selected_post" @click.prevent="selected_post=''" right><i class="material-icons">close</i></b-nav-item>
    </b-navbar-nav>
  </b-navbar>

	<post ref='post' :text-black='postTextBlack' :collapsed='postMenuClose' v-if="selected_post" :post_id="selected_post"></post>
	
<!-- our main component -->
<ksvuefp v-show='!selected_post' :options="options" :sections="sections"> <!-- our section component -->

<ksvuefp-section v-for="(section,index) in sections" :section="section"
	:key="section.bgColor" :section-index="index"
	:background-color="section.bgColor"> <!-- Use Vue-ish way for content animations and transitions. Using !$ksvuefp.slidingActive in v-show will result in content waiting for transitions between sections to finish before animating in -->
<transition name="fade">
<div v-show="$ksvuefp.canAnimContent(index, true)">


	
	
		<blog ref="blog" @select_post='select_post' :posts_list='posts_list' v-if="section.sec_type == 'blog'"></blog>
		<login v-if="section.sec_type == 'login'"></login>
		<div v-if="section.content" class='container'>
			<div  class="row">
				<div class="col-sm">
					<h1>${ section.content }</h1>
				</div>
			</div>
			<div class="row">
			
		</div>
		
	<!--  
	<carousel-3d v-if="section.sec_type == 'img'"> 
				<slide :index="0">
				<figure>
						<img src="https://placehold.it/360x270">
						<figcaption>The sky is the limit only for those who aren't afraid to
							fly! The sky is the limit only for those who aren't afraid to fly!

						</figcaption>
					</figure>
				</slide>
				<slide :index="1"> Slide 2 Content </slide>
				<slide :index="2"> Slide 3 Content </slide>
				<slide :index="3"> Slide 4 Content </slide>
				<slide :index="4">
				Waat
				 </slide> 
	</carousel-3d>
	-->
	
	<!-- youtube iframe with progressive enhancement -->
	<vue-plyr v-if="section.sec_type == 'video'">
	<div class="plyr__video-embed">
		<iframe src="https://www.youtube.com/embed/bTqVqk7FSmY"
			allowfullscreen allowtransparency allow="autoplay"></iframe>
	</div>
	</vue-plyr>

	
			<div v-if="section.sec_type == 'text'" class="row">
			<div class="eg-theme-gourmet">
<!--   <div class="eg-slideshow"> -->
<!--     <slshow></slshow> -->
<!--   </div> -->
</div>
<!-- 			<div class="eg-slideshow"> -->
<!-- 				<slide> -->
<!-- 				<p>Vel minus quaerat sunt corporis odit sunt. Corrupti qui -->
<!-- 						consequuntur esse est libero. A porro beatae veritatis deserunt et -->
<!-- 						qui laudantium.</p> -->
<!-- 				</slide> -->
				
<!-- 				<slide> -->
<!-- 				<p>Cum itaque suscipit est quo et et. Voluptas et sit quia. Aliquam -->
<!-- 						odit repellendus atque distinctio quidem. Aut cum expedita -->
<!-- 						quisquam quos. Accusamus et eveniet unde est.</p> -->
<!-- 				</slide> -->
				
<!-- 				<slide> -->
<!-- 				<p>Consequatur reiciendis odio consectetur a qui. Optio nulla nihil -->
<!-- 						perferendis. Quo labore neque iure. Ut esse eum repudiandae. Illo -->
<!-- 						ea eius est rerum eligendi qui. Tenetur vel necessitatibus -->
<!-- 						voluptas quaerat ex dolores et.</p> -->
<!-- 				</slide> -->
<!-- 			</div> -->
				
			</div>
		</div>


</div>
</transition> </ksvuefp-section> 
</ksvuefp>
  <b-navbar fixed="bottom" type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item href="#">Footer</b-nav-item>
    </b-navbar-nav>
  </b-navbar>
<!-- <div> -->
<!--   <b-navbar type="dark" variant="dark"> -->
<!--     <b-navbar-nav> -->
<!--       <b-nav-item href="#">Footer</b-nav-item> -->
<!--     </b-navbar-nav> -->
<!--   </b-navbar> -->
<!-- </div> -->
{% endblock %}

{% block footer %}
    {{ parent() }}
{% endblock %}