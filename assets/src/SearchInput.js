import React, {Component} from 'react';

class SearchInput extends Component {


    render() {
        return <input  onChange={this.props.onChange}  className="form-control form-control-lg col" type="text" placeholder="Search by name.."/>;
    }
}

export default SearchInput;