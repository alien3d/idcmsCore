/**
 *  optional icon renderer
 */

    {
        dataIndex: "isDefault",
        header: isDefaultLabel,
        sortable: true,
        hidden: isDefaultHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isNew",
        header: isNewLabel,
        sortable: true,
        hidden: isNewHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isDraft",
        header: isDraftLabel,
        sortable: true,
        hidden: isNewHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isUpdate",
        header: isUpdateLabel,
        sortable: true,
        hidden: isUpdateHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isDelete",
        header: isDeleteLabel,
        sortable: true,
        hidden: isDeleteHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isActive",
        header: isActiveLabel,
        sortable: true,
        hidden: isActiveHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isApproved",
        header: isApprovedLabel,
        sortable: true,
        hidden: isApprovedHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "By",
        header: createByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: "Time",
        header: timeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'd-m-Y H:i:s');
        }
    }
