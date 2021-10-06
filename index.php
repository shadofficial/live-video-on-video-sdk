<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Videosdk.live RTC</title>
  </head>
  <body>

  <input type="text" id="meetid" placeholder="Add Meeting Id">
  <input type="text" id="meetn" placeholder="Your Name">
  <button onclick="yahoo();">Add meeting</button>

  <script>
    function makeid(length) {
    var result           = '';
    var characters       = 'bcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   return result;
}
console.log(makeid(5));

    </script>
    <script>
      
      function yahoo(){
      var script = document.createElement("script");
      script.type = "text/javascript";
      //
      script.addEventListener("load", function (event) {
        // Initialize the factory function
        const meeting = new VideoSDKMeeting();
  
        // Set apikey, meetingId and participant name
        const apiKey = "57cc493f-abce-4089-a8a3-d980cd04e294"; // generated from app.videosdk.live
        const meetingId = document.getElementById("meetid").value;
        const name = document.getElementById("meetn").value;

        const config = {
          name: name,
          apiKey: apiKey,
          meetingId: meetingId,

          containerId: null,
          redirectOnLeave: "https://www.videosdk.live/",

          micEnabled: true,
          webcamEnabled: true,
          participantCanToggleSelfWebcam: true,
          participantCanToggleSelfMic: true,

          chatEnabled: true,
          screenShareEnabled: true,
          pollEnabled: true,
          whiteBoardEnabled: true,
          raiseHandEnabled: true,

          recordingEnabled: true,
          recordingWebhookUrl: "https://www.videosdk.live/callback",
          participantCanToggleRecording: true,

          brandingEnabled: true,
          brandLogoURL: "https://picsum.photos/200",
          brandName: "Awesome startup",
          poweredBy: false,

          participantCanLeave: true, // if false, leave button won't be visible

          // Live stream meeting to youtube
          livestream: {
            autoStart: true,
            outputs: [
              // {
              //   url: "rtmp://x.rtmp.youtube.com/live2",
              //   streamKey: "<STREAM KEY FROM YOUTUBE>",
              // },
            ],
          },
        permissions: {
          askToJoin: false, // Ask joined participants for entry in meeting
          toggleParticipantMic: true, // Can toggle other participant's mic
          toggleParticipantWebcam: true, // Can toggle other participant's webcam
        },

        joinScreen: {
          visible: true, // Show the join screen ?
          title: "Daily scrum", // Meeting title
          meetingUrl: window.location.href+makeid(5), // Meeting joining url
        },
      };

        meeting.init(config);
      });

      script.src =
        "https://sdk.videosdk.live/rtc-js-prebuilt/0.1.5/rtc-js-prebuilt.js";
      document.getElementsByTagName("head")[0].appendChild(script);}
    </script>
  </body>
</html>
