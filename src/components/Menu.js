import * as React from 'react';
import { Link } from 'react-router-dom';
import Drawer from '@mui/material/Drawer';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import GroupsIcon from '@mui/icons-material/Groups';
import FaceIcon from '@mui/icons-material/Face';
import SchoolIcon from '@mui/icons-material/School';
import Toolbar from '@mui/material/Toolbar';
import RestaurantIcon from '@mui/icons-material/Restaurant';


export default function Menu() {
    const drawerWidth = 240;
    const list = [
        { text: 'Funcionário', icon: <GroupsIcon />, path: '/' },
        { text: 'Estudante', icon: <FaceIcon />, path: '/estudante' },
        { text: 'Docente', icon: <SchoolIcon />, path: '/docente' },
    ];

    return (
        <Drawer
            sx={{
                width: drawerWidth,
                flexShrink: 0,
                '& .MuiDrawer-paper': {
                    width: drawerWidth,
                    boxSizing: 'border-box',
                    position:'relative',
                    borderRight: 'none'
                },
            }}
            variant="permanent"
            anchor="left"
        >
            <Toolbar/>
            <List>
                {list.map((item, index) => (
                    <ListItem key={index} disablePadding>
                        <ListItemButton component={Link} to={item.path}>
                            <ListItemIcon>
                                {item.icon}
                            </ListItemIcon>
                            <ListItemText primary={item.text} />
                        </ListItemButton>
                    </ListItem>
                ))}
            </List>
        </Drawer>
    );
}
