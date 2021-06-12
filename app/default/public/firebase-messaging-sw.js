
importScripts('https://www.gstatic.com/firebasejs/8.3.3/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.3/firebase-messaging.js');
importScripts('./firebase-init.js');

const messaging = firebase.messaging();


messaging.onBackgroundMessage((payload) => {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  // const notificationTitle = 'Background Message Title';
  // const notificationOptions = {
    // body: 'Background Message body.',
    // icon: '/firebase-logo.png'
  // };

  // self.registration.showNotification(notificationTitle,
    // notificationOptions);
});
