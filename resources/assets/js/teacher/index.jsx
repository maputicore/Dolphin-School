import React, { Component } from 'react';
import { render } from 'react-dom';
import {Router, Route, browserHistory} from 'react-router';
import App from './app.jsx';
import Login from './auth/login.jsx';
import Home from './home.jsx';


render(
    <Router history={browserHistory}>
        <Route path="/" component={App}>
            <Route path="login" component={Login}/>
        </Route>
    </Router>,
    document.getElementById('app')
);
