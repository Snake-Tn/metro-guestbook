import React from "react";
import request from 'request-promise';
import {Redirect} from 'react-router'
import {withRouter} from 'react-router-dom';

class Login extends React.Component {

    constructor(props) {
        super(props);
        this.state = {login: '', password: ''};
        this.onLoginChange = this.onLoginChange.bind(this);
        this.onPasswordChange = this.onPasswordChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    onLoginChange(event) {
        this.setState({login: event.target.value, error: ""});
    }

    onPasswordChange(event) {
        this.setState({password: event.target.value, error: ""});
    }

    handleSubmit(event) {
        request('http://localhost:8001/api/auth/token?login=' + this.state.login + '&password=' + this.state.password)
            .then(function (response) {
                localStorage.token = response;
                this.props.setLoggedIn(true);
                return response;
            }.bind(this))
            .catch(function (err) {
                const body = JSON.parse(err.error);
                this.setState({error: body.error});
            }.bind(this));

        event.preventDefault();
    }

    render() {
        const redirectTo = this.props.location.state && this.props.location.state.destination ? this.props.location.state.destination : '/';
        return <div className="container">
            {this.props.isLoggedIn && <Redirect to={redirectTo}/>}
            <div className="login-form row justify-content-center align-items-center">
                <div className="col-4">
                    <div className="card">
                        <div className="card-body">
                            <form onSubmit={this.handleSubmit}>
                                <div className="form-group">
                                    <input value={this.state.login} onChange={this.onLoginChange} type="text"
                                           className="form-control" placeholder="login"/>
                                </div>
                                <div className="form-group">
                                    <input value={this.state.password} onChange={this.onPasswordChange} type="password"
                                           className="form-control" placeholder="password"/>
                                </div>
                                <div className="text-danger error">{this.state.error}</div>
                                <button type="submit" value="submit" className="btn btn-primary">login</button>

                            </form>

                        </div>
                        <br/>
                        &nbsp; Demo accounts:
                        <table className="table">
                            <thead>
                            <tr>
                                <th scope="col">Login</th>
                                <th scope="col">Password</th>
                                <th scope="col">Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td>guest1</td>
                                <td>guest1</td>
                                <td>Guest</td>
                            </tr>
                            <tr>

                                <td>admin1</td>
                                <td>admin1</td>
                                <td>Admin</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>;
    }
}

export default withRouter(Login);