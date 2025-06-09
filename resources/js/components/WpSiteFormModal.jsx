import React, { useEffect } from "react";
import { Modal, Form, Input, Button } from "antd";

const { Item } = Form;

const WpSiteFormModal = ({ visible, onCancel, onSubmit, initialValues, loading }) => {
    const [form] = Form.useForm();

    useEffect(() => {
        if (visible && initialValues) {
            form.setFieldsValue({
                ...initialValues
            });
        } else if (visible) {
            form.resetFields();
        }
    }, [visible, initialValues]);

    return (
        <Modal
            open={visible}
            onCancel={onCancel}
            footer={null}
            title={initialValues ? "Edit site" : "Add site"}
            destroyOnClose
        >
            <Form
                form={form}
                layout="vertical"
                onFinish={onSubmit}
            >
                <Item
                    label="Site URL"
                    name="site_url"
                    rules={[{ required: true, type: "url", message: "Enter a valid URL" }]}
                >
                    <Input />
                </Item>
                <Item
                    label="Admin URL"
                    name="admin_url"
                    rules={[{ required: true, type: "url", message: "Enter a valid URL" }]}
                >
                    <Input />
                </Item>
                <Item
                    label="Admin Login"
                    name="admin_login"
                    rules={[{ required: true, message: "Required" }]}
                >
                    <Input />
                </Item>
                <Item
                    label="Admin Password"
                    name="admin_password"
                    rules={[{ required: !initialValues, message: "Required" }]}
                >
                    <Input.Password />
                </Item>
                <Item label="Server Host" name="server_host">
                    <Input />
                </Item>
                <Item label="Server Login" name="server_login">
                    <Input />
                </Item>
                <Item label="Server Password" name="server_password">
                    <Input.Password />
                </Item>
                <Item label="CDN Name" name="cdn_name">
                    <Input />
                </Item>
                <Item label="CDN Login" name="cdn_login">
                    <Input />
                </Item>
                <Item label="CDN Password" name="cdn_password">
                    <Input.Password />
                </Item>
                <Button
                    type="primary"
                    htmlType="submit"
                    block
                    loading={loading}
                >
                    {initialValues ? "Update site" : "Create site"}
                </Button>
            </Form>
        </Modal>
    );
};

export default WpSiteFormModal;
