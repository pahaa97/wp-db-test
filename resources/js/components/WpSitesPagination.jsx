import React from "react";
import { Pagination } from "antd";

const WpSitesPagination = ({ meta, onChange }) => (
    <div style={{ textAlign: "right", marginTop: 24 }}>
        <Pagination
            current={meta.current_page}
            total={meta.total}
            pageSize={meta.per_page}
            showSizeChanger={false}
            onChange={onChange}
        />
    </div>
);

export default WpSitesPagination;
