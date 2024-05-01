import { createBrowserRouter } from "react-router-dom";
export const router = createBrowserRouter([
    {
        path: "/",
        element: "<p> Hi from HomePage </p>",
    },
    {
        path: "/login",
        element: "<p> Hi from HomePage </p>",
    },
    {
        path: "/register",
        element: "<p> Hi from register </p>",
    },
    {
        path: "/users",
        element: "<p> Hi from users </p>",
    },
]);
