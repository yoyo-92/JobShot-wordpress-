<?php
function name_of_student_item_func($id){
    $names=array(
    'eval-1'=> '実行力',
    'eval-2'=> '主体性',
    'eval-3'=> '課題発見力',
    'eval-4'=> '創造力',
    'eval-5'=> 'リーダーシップ力',
    'eval-6'=> 'ストレス耐性',
    'eval-7'=> '素直さ',
    'eval-8'=> '協調性',
    'eval-9'=> '論理的説明力',
    'eval-10'=> 'コミュニケーション能力',
    1=> '実行力',
    2=> '主体性',
    3=> '課題発見力',
    4=> '創造力',
    5=> 'リーダーシップ力',
    6=> 'ストレス耐性',
    7=> '素直さ',
    8=> '協調性',
    9=> '論理的説明力',
    10=> 'コミュニケーション能力',
    );
    return $names[$id];
}
wpcf7_add_form_tag('name_of_student_item','name_of_student_item_func');
add_shortcode('name_of_student_item','name_of_student_item_func');

function name_of_student_item1_func(){
    return name_of_student_item_func(1);
}
add_shortcode('name_of_student_item1','name_of_student_item1_func');

function name_of_student_item2_func(){
    return name_of_student_item_func(2);
}
add_shortcode('name_of_student_item2','name_of_student_item2_func');

function name_of_student_item3_func(){
    return name_of_student_item_func(3);
}
add_shortcode('name_of_student_item3','name_of_student_item3_func');

function name_of_student_item4_func(){
    return name_of_student_item_func(4);
}
add_shortcode('name_of_student_item4','name_of_student_item4_func');

function name_of_student_item5_func(){
    return name_of_student_item_func(5);
}
add_shortcode('name_of_student_item5','name_of_student_item5_func');

function name_of_student_item6_func(){
    return name_of_student_item_func(6);
}
add_shortcode('name_of_student_item6','name_of_student_item6_func');

function name_of_student_item7_func(){
    return name_of_student_item_func(7);
}
add_shortcode('name_of_student_item7','name_of_student_item7_func');

function name_of_student_item8_func(){
    return name_of_student_item_func(8);
}
add_shortcode('name_of_student_item8','name_of_student_item8_func');

function name_of_student_item9_func(){
    return name_of_student_item_func(9);
}
add_shortcode('name_of_student_item9','name_of_student_item9_func');

function name_of_student_item10_func(){
    return name_of_student_item_func(10);
}
add_shortcode('name_of_student_item10','name_of_student_item10_func');
  
  
  function getmydata_func( $atts, $content = null ) {
      extract( shortcode_atts( array(
          'id' => '', 
              'item_name' => '',
        'user_id' =>'' ,
      ), $atts ) );
    $event_feedback_form_name='イベントフィードバックフォーム';
  
      $user = wp_get_current_user();  
    $eval=get_user_meta( $user->ID, $item_name);
    return do_shortcode('[cfdb-value function="mean" form="'.$event_feedback_form_name.'" filter="partner-id='.$user -> user_login.'" show="'.$item_name.'"]');
  }
  add_shortcode('getmydata', 'getmydata_func');
  
  
  function test_num(){
    return 123;
  }
  add_shortcode('test_num','test_num');
  
  
  add_action( 'wpcf7_before_send_mail', function($contact_form) {
      $submission = WPCF7_Submission::get_instance(); 
    if($submission){
      $data = $submission->get_posted_data();
      if(isset($data['partner-id'])){
        $user = get_user_by( 'login', $data['partner-id'] );
        
        $event_feedback_form_name='イベントフィードバックフォーム';
        
         $eval_names = array('eval-1', 'eval-2', 'eval-3', 'eval-4', 'eval-5', 'eval-6');
  foreach ($eval_names as &$eval_name) {	
  if(isset($data[$eval_name])){
    
        delete_user_meta( $user->ID, $eval_name);
        delete_user_meta( $user->ID, $eval_name.'-cnt');
  
  
  
    $p_eval=get_user_meta( $user->ID, $eval_name);
  $p_cnt=get_user_meta( $user->ID, $eval_name.'-cnt');
        if($p_eval){
           update_user_meta($user->ID, $eval_name, do_shortcode('[cfdb-value function="mean" form="'.$event_feedback_form_name.'" filter="partner-id='.$user -> user_login.'" show="'.$eval_name.'"]'));
        }else{
      //	 add_user_meta($user->ID, $eval_name, 5);
  //		 add_user_meta($user->ID, $eval_name, do_shortcode('[cfdb-value function="mean" form="'.$event_feedback_form_name.'" filter="partner-id='.$user -> user_login.'" show="'.$eval_name.'"]'));
  //	  		 add_user_meta($user->ID, $eval_name, do_shortcode('[cfdb-value function="mean" form="イベントフィードバックフォーム" filter="partner-id=hirata1" show="eval-1"]'));
  }
        if($p_cnt){
           update_user_meta($user->ID, $eval_name.'-cnt', do_shortcode('[cfdb-value function="count" form="'.$event_feedback_form_name.'" filter="partner-id='.$user -> user_login.'" show="'.$eval_name.'"]'));
        }else{
      //	 add_user_meta($user->ID, $eval_name.'-cnt', 2);
  //add_user_meta($user->ID, $eval_name.'-cnt', do_shortcode('[cfdb-value function="count" form="'.$event_feedback_form_name.'" filter="partner-id='.$user -> user_login.'" show="'.$eval_name.'"]'));
                     add_user_meta($user->ID, $eval_name, do_shortcode('[test_num]'));
        }
  }
  }
      }
    }
  });
  
  
  function draw_graph_func(){
    return do_shortcode(' 
    [d3-source canvas="mychart"]
  
    var RadarChart = {
    draw: function(id, d, options){
      var cfg = {
       radius: 5,
       w: 600,
       h: 600,
       factor: 1,
       factorLegend: .85,
       levels: 3,
       maxValue: 0,
       radians: 2 * Math.PI,
       opacityArea: 0.5,
       ToRight: 5,
       TranslateX: 80,
       TranslateY: 30,
       ExtraWidthX: 100,
       ExtraWidthY: 100,
       color: d3.scale.ordinal().range(["#03c4b0", "#CA0D59"])
      };
      
      if("undefined" !== typeof options){
        for(var i in options){
        if("undefined" !== typeof options[i]){
          cfg[i] = options[i];
        }
        }
      }
      
  //    cfg.maxValue = 100;
      
      var allAxis = (d[0].map(function(i, j){return i.area}));
      var total = allAxis.length;
      var radius = cfg.factor*Math.min(cfg.w/2, cfg.h/2);
      var Format = d3.format("%");
      d3.select(id).select("svg").remove();
  
      var g = d3.select(id)
          .append("svg")
          .attr("width", cfg.w+cfg.ExtraWidthX)
          .attr("height", cfg.h+cfg.ExtraWidthY)
          .append("g")
          .attr("transform", "translate(" + cfg.TranslateX + "," + cfg.TranslateY + ")");
  
          var tooltip;
      
      //Circular segments
      for(var j=0; j<cfg.levels; j++){
        var levelFactor = cfg.factor*radius*((j+1)/cfg.levels);
        g.selectAll(".levels")
         .data(allAxis)
         .enter()
         .append("svg:line")
         .attr("x1", function(d, i){return levelFactor*(1-cfg.factor*Math.sin(i*cfg.radians/total));})
         .attr("y1", function(d, i){return levelFactor*(1-cfg.factor*Math.cos(i*cfg.radians/total));})
         .attr("x2", function(d, i){return levelFactor*(1-cfg.factor*Math.sin((i+1)*cfg.radians/total));})
         .attr("y2", function(d, i){return levelFactor*(1-cfg.factor*Math.cos((i+1)*cfg.radians/total));})
         .attr("class", "line")
         .style("stroke", "grey")
         .style("stroke-opacity", "0.75")
         .style("stroke-width", "0.3px")
         .attr("transform", "translate(" + (cfg.w/2-levelFactor) + ", " + (cfg.h/2-levelFactor) + ")");
      }
  
      //Text indicating at what % each level is
      for(var j=0; j<cfg.levels; j++){
        var levelFactor = cfg.factor*radius*((j+1)/cfg.levels);
        g.selectAll(".levels")
         .data([1]) //dummy data
         .enter()
         .append("svg:text")
         .attr("x", function(d){return levelFactor*(1-cfg.factor*Math.sin(0));})
         .attr("y", function(d){return levelFactor*(1-cfg.factor*Math.cos(0));})
         .attr("class", "legend")
         .style("font-family", "sans-serif")
         .style("font-size", "10px")
         .attr("transform", "translate(" + (cfg.w/2-levelFactor + cfg.ToRight) + ", " + (cfg.h/2-levelFactor) + ")")
         .attr("fill", "#737373")
         .text((j+1)*cfg.maxValue/cfg.levels);
      }
  
      series = 0;
  
      var axis = g.selectAll(".axis")
          .data(allAxis)
          .enter()
          .append("g")
          .attr("class", "axis");
  
      axis.append("line")
        .attr("x1", cfg.w/2)
        .attr("y1", cfg.h/2)
        .attr("x2", function(d, i){return cfg.w/2*(1-cfg.factor*Math.sin(i*cfg.radians/total));})
        .attr("y2", function(d, i){return cfg.h/2*(1-cfg.factor*Math.cos(i*cfg.radians/total));})
        .attr("class", "line")
        .style("stroke", "grey")
        .style("stroke-width", "1px");
  
      axis.append("text")
        .attr("class", "legend")
        .text(function(d){return d})
        .style("font-family", "sans-serif")
        .style("font-size", "13px")
        .attr("text-anchor", "middle")
        .attr("dy", "1.2em")
        .attr("transform", function(d, i){return "translate(0, -10)"})
        .attr("x", function(d, i){return cfg.w/2*(1-cfg.factorLegend*Math.sin(i*cfg.radians/total))-60*Math.sin(i*cfg.radians/total);})
        .attr("y", function(d, i){return cfg.h/2*(1-Math.cos(i*cfg.radians/total))-20*Math.cos(i*cfg.radians/total);});
  
   
      d.forEach(function(y, x){
        dataValues = [];
        g.selectAll(".nodes")
        .data(y, function(j, i){
          dataValues.push([
          cfg.w/2*(1-(parseFloat(Math.max(j.value, 0))/cfg.maxValue)*cfg.factor*Math.sin(i*cfg.radians/total)), 
          cfg.h/2*(1-(parseFloat(Math.max(j.value, 0))/cfg.maxValue)*cfg.factor*Math.cos(i*cfg.radians/total))
          ]);
        });
        dataValues.push(dataValues[0]);
        g.selectAll(".area")
               .data([dataValues])
               .enter()
               .append("polygon")
               .attr("class", "radar-chart-serie"+series)
               .style("stroke-width", "2px")
               .style("stroke", cfg.color(series))
               .attr("points",function(d) {
                 var str="";
                 for(var pti=0;pti<d.length;pti++){
                   str=str+d[pti][0]+","+d[pti][1]+" ";
                 }
                 return str;
                })
               .style("fill", function(j, i){return cfg.color(series)})
               .style("fill-opacity", cfg.opacityArea)
               .on("mouseover", function (d){
                        z = "polygon."+d3.select(this).attr("class");
                        g.selectAll("polygon")
                         .transition(200)
                         .style("fill-opacity", 0.1); 
                        g.selectAll(z)
                         .transition(200)
                         .style("fill-opacity", .7);
                        })
               .on("mouseout", function(){
                        g.selectAll("polygon")
                         .transition(200)
                         .style("fill-opacity", cfg.opacityArea);
               });
        series++;
      });
      series=0;
  
  
  var tooltip = d3.select("body").append("div").attr("class", "toolTip");
      d.forEach(function(y, x){
        g.selectAll(".nodes")
        .data(y).enter()
        .append("svg:circle")
        .attr("class", "radar-chart-serie"+series)
        .attr("r", cfg.radius)
        .attr("alt", function(j){return Math.max(j.value, 0)})
        .attr("cx", function(j, i){
          dataValues.push([
          cfg.w/2*(1-(parseFloat(Math.max(j.value, 0))/cfg.maxValue)*cfg.factor*Math.sin(i*cfg.radians/total)), 
          cfg.h/2*(1-(parseFloat(Math.max(j.value, 0))/cfg.maxValue)*cfg.factor*Math.cos(i*cfg.radians/total))
        ]);
        if(isNaN(j.value)){return cfg.w/2;}
        return cfg.w/2*(1-(Math.max(j.value, 0)/cfg.maxValue)*cfg.factor*Math.sin(i*cfg.radians/total));
        })
        .attr("cy", function(j, i){
              if(isNaN(j.value)){return cfg.h/2;}
          return cfg.h/2*(1-(Math.max(j.value, 0)/cfg.maxValue)*cfg.factor*Math.cos(i*cfg.radians/total));
        })
        .attr("data-id", function(j){return j.area})
        .style("fill", "#fff")
        .style("stroke-width", "2px")
        .style("stroke", cfg.color(series)).style("fill-opacity", .9)
        .on("mouseover", function (d){
          console.log(d.area)
              tooltip
                .style("left", d3.event.pageX - 40 + "px")
                .style("top", d3.event.pageY - 80 + "px")
                .style("display", "inline-block")
                        .html((d.area) + "<br><span>" + (d.value) + "</span>");
              })
              .on("mouseout", function(d){ tooltip.style("display", "none");});
  
        series++;
      });
      }
  };
  var width = 200,
      height = 200;
  
  // Config for the Radar chart
  var mycfg = {
      w: width,
      h: height,
      maxValue: 5,
      levels: 5,
      ExtraWidthX: 150,
      ExtraWidthY: 100
  }
  
  
  var d = [
            [
                {area:"'.name_of_student_item_func('eval-1').'",value:'.do_shortcode('[getmydata item_name="eval-1"]').'},
              {area:"'.name_of_student_item_func('eval-2').'",value:'.do_shortcode('[getmydata item_name="eval-2"]').'},
              {area:"'.name_of_student_item_func('eval-3').'",value:'.do_shortcode('[getmydata item_name="eval-3"]').'},
              {area:"'.name_of_student_item_func('eval-4').'",value:'.do_shortcode('[getmydata item_name="eval-4"]').'},
              {area:"'.name_of_student_item_func('eval-5').'",value:'.do_shortcode('[getmydata item_name="eval-5"]').'},
              {area:"'.name_of_student_item_func('eval-6').'",value:'.do_shortcode('[getmydata item_name="eval-6"]').'},
  
  ]
          ];
              
              
              
              RadarChart.draw(".mychart", d, mycfg);
              
              
  var svg = d3.select("body")
      .selectAll("svg")
      .append("svg")
      .attr("width", width)
      .attr("height", height);
  
  [/d3-source]
  <style>
  
  .mychart {
  /*		  position: absolute;
            top: 50px;
            left: 100px;
      */	}	
      </style>
    ');
    
  /*
  return do_shortcode('  WP-D3 を使ったグラフのサンプル
  
  [d3-source canvas="hist-test"]
  var svgWidth = 480;
  var svgHeight = 250;
  var margin = {top: 10, right: 10, bottom: 30, left: 30};
  var width = svgWidth - margin.left - margin.right;
  var height = svgHeight - margin.top - margin.bottom;
  var xMin = 0;
  var xMax = 50;
  var xTicks = 25;
  var dataSet = [
      43,  43,  43,  42,  41,  40,  40,  39,  39,  39,  38,  38,  38,  38,  38,
      38,  37,  37,  37,  37,  37,  37,  37,  36,  36,  36,  36,  36,  36,  35,
      35,  35,  35,  35,  34,  34,  34,  34,  33,  33,  33,  33,  32,  32,  32,
      32,  32,  31,  31,  31,  31,  30,  30,  29,  29,  29,  29,  29,  29,  29,
      29,  28,  28,  28,  28,  28,  28,  28,  28,  28,  28,  27,  27,  27,  27,
      27,  26,  26,  26,  26,  26,  25,  25,  25,  25,  25,  25,  25,  24,  24,
      24,  24,  24,  24,  24,  24,  24,  23,  23,  23,  23,  22,  22,  22,  22,
      22,  22,  22,  22,  22,  21,  21,  21,  21,  21,  21,  21,  20,  20,  20,
      20,  19,  19,  19,  18,  18,  18,  17,  17,  16,  16,  15,  15,  15,  15,
      15,  14,  14,  14,  14,  13,  12,  10,  10,'
  .do_shortcode('[getmydata item_name="eval-3"]').','
  .do_shortcode('[getmydata item_name="eval-4"]').','
  .do_shortcode('[getmydata item_name="eval-5"]').','
  .do_shortcode('[getmydata item_name="eval-6"]').',
  ];
  
  var xScale = d3.scale.linear()
      .domain([xMin, xMax])
      .range([0, width]);
  
  var data = d3.layout.histogram()
      .bins(xScale.ticks(xTicks))
      (dataSet);
  
  var yScale = d3.scale.linear()
      .domain([0, d3.max(data, function(d) { return d.y; })])
      .range([height, 0]);
  
  var xAxis = d3.svg.axis()
      .scale(xScale)
      .orient("bottom");
  
  var yAxis = d3.svg.axis()
      .scale(yScale)
      .orient("left");
  
  var svg = d3.select(".hist-test")
      .append("svg")
      .attr("width", svgWidth)
      .attr("height", svgHeight)
      .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  
  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);
  
  svg.append("g")
      .attr("class", "y axis")
      .attr("transform", "translate(0,0)")
      .call(yAxis);
  
  var bar = svg.selectAll(".bar")
      .data(data)
      .enter()
      .append("g")
      .attr("class", "bar")
      .attr("transform", function(d) { return "translate(" + xScale(d.x) + "," + yScale(d.y) + ")"; });
  
  bar.append("rect")
      .attr("x", 1)
      .attr("width", xScale(data[0].dx) - 1)
      .attr("height", function(d) { return height - yScale(d.y); });
  
  bar.append("text")
      .attr("class", "tip")
      .attr("dy", ".75em")
      .attr("y", 5)
      .attr("x", xScale(data[0].dx) / 2)
      .attr("text-anchor", "middle")
      .text(function(d) { return d.y; });
  [/d3-source]
  
  <style>
  svg {
    background-color: #fff;
  }
  .bar rect {
    fill: steelblue;
    shape-rendering: crispEdges;
  }
  .bar text {
    fill: #fff;
  }
  .axis path, .axis line {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
  }
  .axis {
    font: 10px sans-serif;
  }
  .tip {
    font: 8px sans-serif;
  }
  </style>');
  */
    
    
  }
  add_shortcode('drawgraph', 'draw_graph_func');
  
  
?>