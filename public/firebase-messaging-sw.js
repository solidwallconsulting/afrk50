 // Scripts for firebase and firebase messaging
 importScripts("https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js");
 importScripts("https://www.gstatic.com/firebasejs/8.2.0/firebase-messaging.js");

 // Initialize the Firebase app in the service worker by passing the generated config
 const firebaseConfig = {
    apiKey: "AIzaSyD3Eh_bUDjY-rELVn15zYR9-KsdykcCQXE",
    authDomain: "map-aot-4a4e2.firebaseapp.com",
    projectId: "map-aot-4a4e2",
    storageBucket: "map-aot-4a4e2.appspot.com",
    messagingSenderId: "756984865725",
    appId: "1:756984865725:web:51e2214b1cbaa46d1a28d4",
    measurementId: "G-P3KQJTF61X"
 };

 firebase.initializeApp(firebaseConfig);

 // Retrieve firebase messaging
 const messaging = firebase.messaging();

 messaging.onBackgroundMessage(function(payload) {
   console.log("Received background message ", payload);

   const notificationTitle = payload.data.title;
   const notificationOptions = {
     body: payload.data.body,
   };

   self.registration.showNotification(notificationTitle, notificationOptions);

   

 });