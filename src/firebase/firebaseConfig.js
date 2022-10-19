// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAKF-ArG7xB44rd0csjkct0sK4NWVpfRFU",
  authDomain: "face-recognition-app-5d699.firebaseapp.com",
  projectId: "face-recognition-app-5d699",
  storageBucket: "face-recognition-app-5d699.appspot.com",
  messagingSenderId: "833855827320",
  appId: "1:833855827320:web:9ecede227e91e92f4b6c8d",
  databaseURL:
    "https://face-recognition-app-5d699-default-rtdb.asia-southeast1.firebasedatabase.app/",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

export default app;
