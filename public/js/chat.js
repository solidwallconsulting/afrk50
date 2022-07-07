const firebaseConfig = {
    apiKey: "AIzaSyD3Eh_bUDjY-rELVn15zYR9-KsdykcCQXE",
    authDomain: "map-aot-4a4e2.firebaseapp.com",
    projectId: "map-aot-4a4e2",
    storageBucket: "map-aot-4a4e2.appspot.com",
    messagingSenderId: "756984865725",
    appId: "1:756984865725:web:51e2214b1cbaa46d1a28d4",
    measurementId: "G-P3KQJTF61X"
  };
  
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

   
const db = firebase.firestore();
const messaging = firebase.messaging();


 



 messaging.getToken({vapidKey: "BIeKx7OMgN3htKCus23RAXheOLKo7AbWqWVme0g1y1IVEcrZ_wq39sUlggmiH7-2yXQfDrEtRhzWK-k2kT4Mhjg"}).then((currentToken) => {
    if (currentToken) {
      console.log(currentToken);

      const url = '/account/fcm/chat/update-my-token';
      $.post(
        url,
        {fcm:currentToken}
        
      ).done((data)=>{
        console.log(data);
      })


    } else {
      // Show permission request UI
      console.log('No registration token available. Request permission to generate one.');
      // ...
    }
  }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
  });
 






//db.collection('user').add({}).then(()=>{})