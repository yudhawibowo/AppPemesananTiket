importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyBRijqPfTDr4waR7H8F9mCiketbNt9CQWE",
    authDomain: "gca-fcm.firebaseapp.com",
    projectId: "gca-fcm",
    storageBucket: "gca-fcm.appspot.com",
    messagingSenderId: "899276026152",
    appId: "1:899276026152:web:0504da476874f46dd6a01d",
    measurementId: "G-61X4Z9HQBY"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification = JSON.parse(payload);
    const notificationOption = {
        body: notification.body,
        icon: notification.icon
    };
    return self.registration.showNotification(payload.notification.title, notificationOption);
});