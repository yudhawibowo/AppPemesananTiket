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

function IntitalizeFireBaseMessaging() {
    messaging
        .requestPermission()
        .then(function () {
            console.log("Notification Permission");
            return messaging.getToken();
        })
        .then(function (token) {
            console.log(token);
            document.getElementById("token-web").value = token;
        })
        .catch(function (reason) {
            console.log(reason);
        });
}

messaging.onMessage(function (payload) {
    console.log(payload);
    const notificationOption = {
        body: payload.notification.body,
        icon: payload.notification.icon
    };
    if (Notification.permission === "granted") {
        var notification = new Notification(payload.notification.title, notificationOption);

        notification.onclick = function (ev) {
            ev.preventDefault();
            window.open(payload.notification.click_action, '_blank');
            notification.close();
        }
    }
});

messaging.onTokenRefresh(function () {
    messaging.getToken()
        .then(function (newtoken) {
            console.log("New Token : " + newtoken);
        })
        .catch(function (reason) {
            console.log(reason);
        })
})