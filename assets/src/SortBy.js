import React, {Component} from 'react';

class SortBy extends Component {

    getSortCriteriaListComponents(sortCriteriaList) {
        return sortCriteriaList.map(function (sortCriteria, index) {
            return <option key={index} value={sortCriteria}>{sortCriteria}</option>
        })
    }

    render() {
        return <select onChange={this.props.onChange} className="form-control form-control-lg col-lg-5">
            {this.getSortCriteriaListComponents(this.props.sortCriteriaList)}
        </select>;
    }
}

export default SortBy;