@extends('layouts.vitumob')

{{-- Web site Title --}}
@section('title')
@parent
:: F.A.Q.
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/faq.css')}} "> -->
@stop


@section('main')

<div id='main' class=''>


<h1>Frequently Asked Questions</h1>

<div>

<a href='#q1'>What is VituMob&copy;?</a></br>

<a href='#q2'>How do I get started?</a></br>

<a href='#q3'>I have downloaded the VituMob&copy; software. How do I buy?</a></br>

<a href='#q4'>I am shopping on Amazon.com and click Checkout. What do I do next?</a></br>

<a href='#q5'>How long does delivery take?</a></br>

<a href='#q6'>How do I pay?</a></br>

<a href='#q7'>What happens if I am not satisfied with the product I receive?</a></br>

<a href='#q8'>Are there any additional customs or delivery charges when I receive my order?</a></br>

<a href='#q9'>VituMob&copy; does not download. Why not?</a></br>

<a href='#q10'>I really want to buy from a website but VituMob&copy; does not sell from that website. Is there anything I can do?</a></br>

<a href='#q11'>How do you deliver?</a></br>

<a href='#q12'>How much does delivery cost?</a></br>

<a href='#q13'>Where does VituMob&copy; deliver?</a></br>

<a href='#q14'>Should I tip my VituMob&copy; delivery person?</a></br>

<a href='#q15'>That cool music from your video, where did you get that?</a></br>

</div>


<h3><a name='q1'>What is VituMob?</a></h3>

<p class='faq-answer'>VituMob&copy; enables Kenyans to shop online at over twenty leading ecommerce websites from around the world using M-Pesa or a credit card. And VituMob&copy; delivers to your doorstep.</p>


<h3><a name='q2'>How do I get started?</a></h3>

<p class='faq-answer'>The process is simple. First, click the download button at <a href='../'>vitumob.com</a> to install an extension for your web browser. The process should take only a few seconds, and you will know that your download has succeeded when the VituMob&copy; button <img src='../favicon.ico'> appears at the upper right corner of your browser window.</p>


<h3><a name='q3'>I have downloaded the VituMob&copy; software. How do I buy?</a></h3>

<ol class='faq-answer'>
  
  <li>Click on any of the VituMob&copy; supported websites (Amazon.com, Macys.com, etc.)
  
  <li>Choose the products you would like to purchase and add them to your shopping cart.
  
  <li>When you are ready to Checkout, click on the VituMob&copy; button <img src='../favicon.ico'> on your browser.
  
  <li>View your shopping cart and complete your purchase.
  
</ol>


<h3><a name='q4'>I am shopping on Amazon.com and click Checkout. What do I do next?</a></h3>

<p class='faq-answer'>There is no need to click the Checkout button on any website. Once you have loaded your shopping cart, please click the VituMob&copy; button <img src='../favicon.ico'> on your web browser instead.</p>


<h3><a name='q5'>How long does delivery take?</a></h3>

<p class='faq-answer'>Delivery takes up to three weeks, but we ordinarily deliver within about ten days. You will receive an email message with a link to check the status of your order.</p>


<h3><a name='q6'>How do I pay?</a></h3>

<p class='faq-answer'>VituMob&copy; accepts MPesa, Visa and MasterCard. If you would like to buy using another form of payment, please contact us at <a href='mailto:contact@vitumob.com'>contact@vitumob.com</a>.</p>


<h3><a name='q7'>What happens if I am not satisfied with the product I receive?</a></h3>

<p class='faq-answer'>VituMob&copy; will deliver to you the exact product you ordered. If unable to do so, VituMob&copy; will refund your payment in full. For additional information, please see the VituMob&copy; Returns Policy.</p>


<h3><a name='q8'>Are there any additional customs or delivery charges when I receive my order?</a></h3>

<p class='faq-answer'>No. Your order is paid in full.</p>


<h3><a name='q9'>VituMob&copy; does not download. Why not?</a></h3>

<p class='faq-answer'>Please email any technical problems to <a href='mailto:help@vitumob.com'>help@vitumob.com</a>. You must be using Firefox, Chrome or Safari web browser to use VituMob. VituMob&copy; does not run on Internet Explorer. VituMob&copy; mobile is currently under development.</p>


<h3><a name='q10'>I really want to buy from a website but VituMob&copy; does not sell from that website. Is there anything I can do?</a></h3>

<p class='faq-answer'>Yes! Please suggest additional sites by emailing <a href='mailto:contact@vitumob.com'>contact@vitumob.com</a>. We want to hear from you.</p>


<h3><a name='q11'>How do you deliver?</a></h3>

<p class='faq-answer'>We deliver VituMob&copy; orders to customers who completed their orders on VituMob.com. We will use your telephone number and your neighbourhood to verify the specific delivery location and time. VituMob&copy; takes security precautions to prevent fraud. We appreciate your understanding in cooperating with such security precautions.</p>


<h3><a name='q12'>How much does delivery cost?</a></h3>

<p class='faq-answer'>Our delivery services are free of charge within Nairobi.</p>


<h3><a name='q13'>Where does VituMob&copy; deliver?</a></h3>

<p class='faq-answer'>We deliver free of charge within Nairobi. We would be happy to deliver your order outside of Nairobi, throughout East Africa. If you are interested in this service, please email contact@vitumob.com.</p>


<h3><a name='q14'>Should I tip my VituMob&copy; delivery person?</a></h3>

<p class='faq-answer'>Tipping is not expected but always appreciated.</p>


<h3><a name='q15'>That cool music from your video, where did you get that?</a></h3>

<p class='faq-answer'>SlumSanaa is a Mathare-based group of musicians who work with their local community to address the most serious problems they face. Our video samples from their song <a href='http://www.youtube.com/watch?v=FQf6R2nVWwQ' target='_blank'>Change We Need</a>. You should support them. Please visit <a href='http://www.facebook.com/slumsanaaa' target='_blank'>their Facebook page</a>.</p>




</div>


@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/faq.js') }}"></script> -->
@stop

