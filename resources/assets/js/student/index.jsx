import React, { Component } from 'react';
import { render } from 'react-dom';
import {Router, Route} from 'react-router';
import Login from './auth/login.jsx';
import Home from './home.jsx';


render(
    <Router>
        <Route path="/" component={Home}/>
        <Route path="/login" component={Login}/>
    </Router>,
    document.getElementById('container')
);
