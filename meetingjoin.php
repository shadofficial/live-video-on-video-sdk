<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Join meeting</title>
</head>
<body>
<style>
@import url("https://fonts.googleapis.com/css?family=Arimo:400,700&display=swap");
:root {
  --color-green: #f44336;
  --color-red: #272628;
  --color-bg: var(--color-red);
  --easing: cubic-bezier(.5, 0, .5, 1);
}

*, *:before, *:after {
  box-sizing: border-box;
  position: relative;
}

body, html {
  height: 100%;
  width: 100%;
  margin: 0;
  padding: 0;
  font-family: "Arimo", sans-serif;
  font-size: 20px;
}

body {
  background-color: var(--color-bg);
  display: flex;
  justify-content: center;
  align-items: center;
}

/* ---------------------------------- */
.modal {
  background: rgba(255, 255, 255, 0.9);
  padding: 0.75rem 1.25rem;
  padding-top: 2rem;
  border-radius: 1rem;
  box-shadow: 0 2rem 12rem rgba(0, 0, 0, 0.5);
  display: grid;
  grid-gap: 1rem;
}
.modal header > h2 {
  font-size: 1rem;
  text-align: center;
  margin: 0;
}

/* ---------------------------------- */
.circles {
  width: 1rem;
  height: 1rem;
  border-radius: 1rem;
  border: 1px solid black;
  border-top-color: transparent;
  border-left-color: transparent;
  margin: 0 auto;
  margin-top: -1.5rem;
  transform: rotate(45deg);
  --pulse: 3s;
  --pulse-delay: calc(var(--pulse) / 5);
}
.circles, .circles:before, .circles:after {
  -webkit-animation: pulse var(--pulse) infinite both;
          animation: pulse var(--pulse) infinite both;
}
.circles:before, .circles:after {
  content: "";
  border: inherit;
  border-radius: inherit;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.circles:before {
  transform: scale(2);
  -webkit-animation-delay: calc(var(--pulse-delay) * 1);
          animation-delay: calc(var(--pulse-delay) * 1);
}
.circles:after {
  transform: scale(3);
  -webkit-animation-delay: calc(var(--pulse-delay) * 2);
          animation-delay: calc(var(--pulse-delay) * 2);
}
@-webkit-keyframes pulse {
  25% {
    border-color: black;
    border-top-color: transparent;
    border-left-color: transparent;
  }
  0%, 65%, 100% {
    border-color: transparent;
    border-top-color: transparent;
    border-left-color: transparent;
  }
}
@keyframes pulse {
  25% {
    border-color: black;
    border-top-color: transparent;
    border-left-color: transparent;
  }
  0%, 65%, 100% {
    border-color: transparent;
    border-top-color: transparent;
    border-left-color: transparent;
  }
}

/* ---------------------------------- */
.status {
  display: grid;
  grid-template-columns: 40px auto;
  grid-gap: 0.5rem;
  align-items: center;
  padding: 0.5rem 0.75rem;
  border-radius: 3rem;
  overflow: hidden;
  overflow: hidden;
}
.status > img {
  display: block;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  border: 1px solid white;
  grid-column: 1;
  grid-row: 1;
}
.status .message {
  grid-column: 2;
  grid-row: 1;
  z-index: 3;
  display: inline-block;
  padding-right: 0.5rem;
}
.status .message.-light {
  color: white;
}
.status:before {
  content: "";
  background-color: var(--color-green);
  transform-origin: center left;
  transform: scaleX(0);
  border-radius: inherit;
}

.status::before,
.pill {
  position: absolute;
  top: 0;
  left: 0;
  margin: auto;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.pill {
  fill: transparent;
  stroke: #ddd;
  stroke-width: 2px;
}
.pill .fill {
  stroke: var(--color-green);
  stroke-dasharray: calc(var(--length, 800) * 1px);
  stroke-dashoffset: calc(var(--length, 800) * 1px);
  transition: stroke-dashoffset 1s cubic-bezier(0.3, 0, 0.7, 1);
}
.modal:not([data-state]) .pill .fill {
  transition: none;
}

.buttons {
  display: grid;
  flex-direction: row;
  justify-content: stretch;
  grid-template-columns: 1fr 1fr;
  padding: 0.5rem 0;
  grid-gap: 0.5rem;
}

.button {
  border: none;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  font: inherit;
  font-weight: bold;
  border-radius: 0.5rem;
  padding: 0.5rem 0;
  grid-row: 1;
  transition: all 0.5s ease;
}
.button.-accept {
  grid-column: 1;
  background-color: var(--color-green);
  color: white;
}
.button.-cancel {
  grid-column: 2;
  background-color: white;
  color: var(--color-red);
}

/* ---------------------------------- */
.modal [data-view] {
  visibility: hidden;
  transition: all 0.4s cubic-bezier(0.5, 0, 0.5, 1), visibility 0s linear 0.4s;
}
.modal [data-active] {
  visibility: visible;
  transition-delay: 0s;
}
.modal .message {
  opacity: 0;
  transform: translateY(100%);
}
.modal .message[data-active] {
  opacity: 1;
  transform: translateY(0);
}
.modal[data-state=prompt] [data-active=prompt] {
  visibility: visible;
  transition-delay: 0s;
}
.modal[data-state=accepted] .button.-accept, .modal[data-state=received] .button.-accept {
  grid-column: 1/-1;
  z-index: 2;
  -webkit-animation: stretch-button 0.5s var(--easing) both;
          animation: stretch-button 0.5s var(--easing) both;
}
@-webkit-keyframes stretch-button {
  from {
    width: calc(var(--width) * 1px);
  }
  to {
    width: 100%;
  }
}
@keyframes stretch-button {
  from {
    width: calc(var(--width) * 1px);
  }
  to {
    width: 100%;
  }
}
.modal[data-state=accepted] .buttons, .modal[data-state=received] .buttons {
  transform-origin: top center;
  -webkit-animation: shrink-up 0.5s 0.3s var(--easing) both;
          animation: shrink-up 0.5s 0.3s var(--easing) both;
}
@-webkit-keyframes shrink-up {
  from {
    height: calc(var(--height) * 1px);
    transform: scaleY(1);
    opacity: 1;
  }
  to {
    transform: scaleY(0);
    height: 0;
    opacity: 0;
  }
}
@keyframes shrink-up {
  from {
    height: calc(var(--height) * 1px);
    transform: scaleY(1);
    opacity: 1;
  }
  to {
    transform: scaleY(0);
    height: 0;
    opacity: 0;
  }
}
.modal[data-state=accepted] .status:before, .modal[data-state=received] .status:before {
  -webkit-animation: status 1s 2s both;
          animation: status 1s 2s both;
}
@-webkit-keyframes status {
  from {
    transform: scaleX(0);
  }
  to {
    transform: scaleX(1);
  }
}
@keyframes status {
  from {
    transform: scaleX(0);
  }
  to {
    transform: scaleX(1);
  }
}
.modal[data-state=accepted] [data-active=accepted] {
  visibility: visible;
  transition-delay: 0s;
}
.modal[data-state=accepted] .pill .fill {
  stroke-dashoffset: 0;
  transition-delay: 1s;
}
.modal[data-state=accepted] .message[data-active=accepted] {
  transform: translateY(0);
}
.modal[data-state=received] [data-active=received] {
  visibility: visible;
  transition-delay: 0s;
}
.modal[data-state=received] .pill .fill {
  stroke-dashoffset: 0;
}
.modal[data-state=received] .message[data-active=received] {
  transform: translateY(0);
  -webkit-animation: unclip 1s both;
          animation: unclip 1s both;
}
@-webkit-keyframes unclip {
  from {
    -webkit-clip-path: polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%);
  }
  to {
    -webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
  }
}
@keyframes unclip {
  from {
    -webkit-clip-path: polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%);
  }
  to {
    -webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
  }
}
.inp {
  position: relative;
  margin: auto;
  width: 100%;
  max-width: 280px;
  height: 53px;
}
.inp .border {
  position: absolute;
  left: 0;
  bottom: 0;
  height: 18px;
  fill: none;
}
.inp .border path {
  stroke: #c8ccd4;
  stroke-width: 2;
}
.inp .border path d {
  transition: all 0.2s ease;
}
.inp .check {
  position: absolute;
  top: 20px;
  right: 20px;
  fill: none;
  transform: translate(0, 9px) scale(0);
  transition: all 0.3s cubic-bezier(0.5, 0.9, 0.25, 1.3);
  transition-delay: 0.15s;
}
.inp .check path {
  stroke: #07f;
  stroke-width: 2;
}
.inp input {
  -webkit-appearance: none;
  width: 100%;
  border: 0;
  font-family: inherit;
  padding: 0;
  height: 48px;
  font-size: 16px;
  font-weight: 500;
  background: none;
  border-radius: 0;
  color: #223254;
  transition: all 0.15s ease;
}
.inp input:focus {
  outline: none;
}
.inp input:focus + .border path {
  stroke: #07f;
}
.inp input:valid + .border path {
  animation: elasticInput 0.8s ease forwards;
}
.inp input:valid + .border + .check {
  transform: translate(0, 0) scale(1);
}
::placeholder {
  color: #9098a9;
}
@-moz-keyframes elasticInput {
  33% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,1 253,1 C261,1 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
  66% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,17 253,17 C261,17 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
}
@-webkit-keyframes elasticInput {
  33% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,1 253,1 C261,1 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
  66% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,17 253,17 C261,17 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
}
@-o-keyframes elasticInput {
  33% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,1 253,1 C261,1 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
  66% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,17 253,17 C261,17 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
}
@keyframes elasticInput {
  33% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,1 253,1 C261,1 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
  66% {
    d: path("M0,12 L226,12 C220,12 220.666667,12 228,12 C239,12 245,17 253,17 C261,17 268,12 278,12 C284.666667,12 285.333333,12 280,12");
  }
}

    </style>

<div id="app">
  <div class="modal">
    <div class="circles"></div>
    <header>
      <h2>Join a meeting</h2>
    </header>
    <div class="status">
      <!-- preserveAspectRatio here fixes the issue we were having with sizing via viewBox: https://css-tricks.com/scale-svg/ -->
      
      <span class="message" data-view="prompt"><b>Add the Meeting Id to join</b> i</span>
      <span class="message" data-view="accepted">Getting...</span>
      <div class="message -light" data-view="received">
        Received!
      </div>
    </div>
    <label for="inp" class="inp">
  <input type="text" id="meetn" placeholder="Your Name" pattern=".{6,}" required>
  <svg width="280px" height="18px" viewBox="0 0 280 18" class="border">
    <path d="M0,12 L223.166144,12 C217.241379,12 217.899687,12 225.141066,12 C236.003135,12 241.9279,12 249.827586,12 C257.727273,12 264.639498,12 274.514107,12 C281.097179,12 281.755486,12 276.489028,12"></path>
  </svg>
  <svg width="14px" height="12px" viewBox="0 0 14 12" class="check">
    <path d="M1 7 5.5 11 L13 1"></path>
  </svg>
</label>
<label for="inp" class="inp">
  <input type="text" id="meetid" placeholder="Meeting Id" pattern=".{6,}" required>
  <svg width="280px" height="18px" viewBox="0 0 280 18" class="border">
    <path d="M0,12 L223.166144,12 C217.241379,12 217.899687,12 225.141066,12 C236.003135,12 241.9279,12 249.827586,12 C257.727273,12 264.639498,12 274.514107,12 C281.097179,12 281.755486,12 276.489028,12"></path>
  </svg>
  <svg width="14px" height="12px" viewBox="0 0 14 12" class="check">
    <path d="M1 7 5.5 11 L13 1"></path>
  </svg>
</label>
   <!-- <input type="text" id="meetid" placeholder="Add Meeting Id">
  <input type="text" id="meetn" placeholder="Your Name">-->
    <footer class="buttons">
      <button class="button -accept" onclick="yahoo();">Join</button>
      <button class="button -cancel"onclick="window.location.href">Cancel</button>
    </footer>
  </div>
</div>
<script src="./js/video.js"></script>

</body>
</html>