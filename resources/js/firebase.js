// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import { onBackgroundMessage } from "firebase/messaging/sw";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDe_0obHF6l6gvLmHG6QjtizXZa3WXUJHc",
    authDomain: "e-commerce-a1189.firebaseapp.com",
    projectId: "e-commerce-a1189",
    storageBucket: "e-commerce-a1189.appspot.com",
    messagingSenderId: "491981020213",
    appId: "1:491981020213:web:67b1a5825e94779c24657c",
    measurementId: "G-32JN0H2H64"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const analytics = getAnalytics(app);
// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = getMessaging(app);

getToken(messaging, { vapidKey: 'BPoAoGzQmXVOoVA54b6A_QruJf-v27_kdLEWw78W1Uiv05ucdnBicJ9pzVoOYFrTHEcKzXN-p0Q_7JPDlVWAIxM' }).then((currentToken) => {
    if (currentToken) {
        console.log(currentToken)
    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        // ...
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
});

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
    // ...
});

onBackgroundMessage(messaging, (payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle,
        notificationOptions);
});

