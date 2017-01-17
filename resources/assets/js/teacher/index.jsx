import { render } from 'react-dom';
import {Router, Route, hashHistory} from 'react-router';
import Helper from '../commons/Helper';
import {Auth, persistAuth} from '../commons/Auth';

import App from './app.jsx';
import Login from './auth/login.jsx';
import Home from './home.jsx';
import NoMatch from './nomatch.jsx';

window.Helper = Helper
let auth = new Auth();

function requireAuth(nextState, replace) {
    if (auth.loggedIn === false) {
        replace({
            pathname: '/login',
            state: {
                returnUrl: nextState.location.pathname
            }
        });
    }
}

function authenticated(nextState, replace) {
    if (auth.loggedIn && auth.user) {
        replace({
            pathname: '/'
        });
    }
}

let routes = (
    <Router history={hashHistory}>
        <Route path="/" component={persistAuth(App, auth)}>
            <Route path="login" component={Login} onEnter={authenticated}/>

            <Route path="home" component={Home} onEnter={requireAuth}/>

        </Route>
    </Router>
);

auth.getAuth(() => {
    render(routes, document.getElementById('app'));
});
