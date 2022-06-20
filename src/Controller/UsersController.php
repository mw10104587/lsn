<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');

        $this->Auth->allow(['register', 'logout']);
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // set default identity as general
            $user->identity = 'general';
            if ($this->Users->save($user)) {
                $this->Flash->success(__(env('DEBUG', false) ? 'You have been registered.' : '登録されました。'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__(env('DEBUG', false) ? 'Unable to finish you register.' : '登録を完了できません。'));
        }
        $this->set('user', $user);
    }

    public function password()
    {
        $user = $this->Users->findById($this->Auth->user('id'))->firstOrFail();
        $this->set(compact('user'));

        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__(env('DEBUG') ? 'Your password has been updated.' : 'パスワードが更新されました。'));
                return $this->redirect(['action' => 'password']);
            }
            $this->Flash->error(__(env('DEBUG', false) ? 'Unable to change your password.' : 'パスワードを変更できません。'));
        }
    }

    public function login()
    {
        // if user is in login state, redirect to menu page
        if($this->Auth->user()) {
            return $this->redirect('/menus');
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // if user logins in login page, redirect to menu page after login
                if($this->Auth->redirectUrl() == '/') {
                    return $this->redirect('/menus');
                }
                // or if user are sign out due to a longer idle state, redirect to user's
                // original page after login
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(env('DEBUG', false) ? 'Your username or password is incorrect.' : 'ユーザー名またはパスワードが正しくありません。');
        }
    }

    public function logout()
    {
        $this->Flash->success( env('DEBUG', false) ? 'You are now logged out.' : 'あなたはログアウトしました。');
        return $this->redirect($this->Auth->logout());
    }

    public function index()
    {
        $users = $this->Paginator->paginate($this->Users->find());
        $this->set(compact('users'));
    }

    public function view($username)
    {
        $user = $this->Users->findByUsername($username)->firstOrFail();
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__(env('DEBUG', false) ? 'Your user has been saved.' : 'ユーザーが保存されました。'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(env('DEBUG', false) ? 'Unable to add your user.' : 'ユーザーを追加できません。'));
        }
        $this->set('user', $user);
    }

    public function edit($id)
    {
        $user = $this->Users->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__(env('DEBUG') ? 'Your user has been updated.' : 'ユーザーが更新されました。'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(env('DEBUG', false) ? 'Unable to update your user.' : 'ユーザーを更新できません。'));
        }

        $this->set('user', $user);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->findById($id)->firstOrFail();
        if ($this->Users->delete($user)) {
            $success_message = env('DEBUG', false) ? __('User {0} has been deleted.', $user->username)
                : __('ユーザー {0} 削除されました。', $user->username);
            $this->Flash->success($success_message);
            return $this->redirect(['action' => 'index']);
        }
    }
}
